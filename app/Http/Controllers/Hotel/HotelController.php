<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\HotelRoom;
use App\Models\HotelBooking;
use App\Models\City;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HotelController extends Controller
{
    // ==================== PUBLIC ====================

    public function index(Request $request)
    {
        $query = Hotel::with(['city', 'rooms'])->where('status', 'approved');
        if ($request->city_id) $query->where('city_id', $request->city_id);
        if ($request->stars)   $query->where('star_rating', $request->stars);
        if ($request->search)  $query->where('name', 'like', '%' . $request->search . '%');
        $hotels = $query->latest()->paginate(12)->withQueryString();
        $cities = City::all();
        return view('hotels.index', compact('hotels', 'cities'));
    }

    public function show(Hotel $hotel)
    {
        if ($hotel->status !== 'approved') abort(404);
        $hotel->load(['city', 'rooms', 'user']);
        return view('hotels.show', compact('hotel'));
    }

    public function bookingForm(Request $request, Hotel $hotel, HotelRoom $room)
    {
        if (!Auth::check()) return redirect()->route('login')->with('status', 'Please login to book a room.');
        return view('hotels.booking', compact('hotel', 'room'));
    }

    public function storeBooking(Request $request, Hotel $hotel, HotelRoom $room)
    {
        if (!Auth::check()) return redirect()->route('login');
        $request->validate([
            'check_in'         => 'required|date|after_or_equal:today',
            'check_out'        => 'required|date|after:check_in',
            'guests'           => 'required|integer|min:1|max:' . $room->capacity,
            'guest_name'       => 'required|string|max:100',
            'guest_phone'      => 'required|string|max:20',
            'special_requests' => 'nullable|string|max:500',
        ]);

        $checkIn  = \Carbon\Carbon::parse($request->check_in);
        $checkOut = \Carbon\Carbon::parse($request->check_out);
        $nights   = $checkIn->diffInDays($checkOut);

        if (!$room->isAvailableForDates($request->check_in, $request->check_out)) {
            return back()->with('error', 'Room is not available for selected dates!');
        }

        $totalAmount      = $nights * $room->price_per_night;
        $commissionRate   = SiteSetting::get('commission_rate', 10) / 100;
        $commissionAmount = $totalAmount * $commissionRate;
        $vendorAmount     = $totalAmount - $commissionAmount;

        $booking = HotelBooking::create([
            'user_id'           => Auth::id(),
            'hotel_id'          => $hotel->id,
            'hotel_room_id'     => $room->id,
            'check_in'          => $request->check_in,
            'check_out'         => $request->check_out,
            'nights'            => $nights,
            'guests'            => $request->guests,
            'room_price'        => $room->price_per_night,
            'total_amount'      => $totalAmount,
            'commission_amount' => $commissionAmount,
            'vendor_amount'     => $vendorAmount,
            'status'            => 'pending',
            'payment_status'    => 'unpaid',
            'special_requests'  => $request->special_requests,
            'guest_name'        => $request->guest_name,
            'guest_phone'       => $request->guest_phone,
        ]);

        return redirect()->route('hotels.booking.success', $booking)->with('success', 'Booking confirmed!');
    }

    public function bookingSuccess(HotelBooking $booking)
    {
        return view('hotels.booking-success', compact('booking'));
    }

    // ==================== VENDOR ====================

    public function vendorDashboard()
    {
        $hotel    = Hotel::where('user_id', Auth::id())->with('rooms', 'bookings')->first();
        $bookings = $hotel ? HotelBooking::where('hotel_id', $hotel->id)->with('user', 'room')->latest()->paginate(10) : collect();
        return view('hotels.vendor.dashboard', compact('hotel', 'bookings'));
    }

    public function vendorCreate()
    {
        $cities = City::all();
        return view('hotels.vendor.create', compact('cities'));
    }

    public function vendorStore(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'address'     => 'required|string',
            'city_id'     => 'required|exists:cities,id',
            'star_rating' => 'required|in:1,2,3,4,5',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('hotels', 'public');
        }

        Hotel::create([
            'user_id'     => Auth::id(),
            'city_id'     => $request->city_id,
            'name'        => $request->name,
            'description' => $request->description,
            'address'     => $request->address,
            'phone'       => $request->phone,
            'email'       => $request->email,
            'star_rating' => $request->star_rating,
            'cover_image' => $coverPath,
            'status'      => 'pending',
        ]);

        return redirect()->route('hotel.vendor.dashboard')->with('success', 'Hotel submitted for approval!');
    }

    public function vendorEdit()
    {
        $hotel  = Hotel::where('user_id', Auth::id())->firstOrFail();
        $cities = City::all();
        return view('hotels.vendor.edit', compact('hotel', 'cities'));
    }

    public function vendorUpdate(Request $request)
    {
        $hotel = Hotel::where('user_id', Auth::id())->firstOrFail();
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'address'     => 'required|string',
            'city_id'     => 'required|exists:cities,id',
            'star_rating' => 'required|in:1,2,3,4,5',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($hotel->cover_image) Storage::disk('public')->delete($hotel->cover_image);
            $hotel->cover_image = $request->file('cover_image')->store('hotels', 'public');
        }

        $hotel->update([
            'city_id'     => $request->city_id,
            'name'        => $request->name,
            'description' => $request->description,
            'address'     => $request->address,
            'phone'       => $request->phone,
            'email'       => $request->email,
            'star_rating' => $request->star_rating,
            'cover_image' => $hotel->cover_image,
        ]);

        return redirect()->route('hotel.vendor.dashboard')->with('success', 'Hotel updated!');
    }

    public function vendorDestroy()
    {
        $hotel = Hotel::where('user_id', Auth::id())->firstOrFail();
        if ($hotel->cover_image) Storage::disk('public')->delete($hotel->cover_image);
        $hotel->delete();
        return redirect()->route('hotel.vendor.dashboard')->with('success', 'Hotel deleted.');
    }

    public function addRoom(Request $request)
    {
        $hotel = Hotel::where('user_id', Auth::id())->firstOrFail();
        $request->validate([
            'name'            => 'required|string|max:100',
            'capacity'        => 'required|integer|min:1',
            'price_per_night' => 'required|numeric|min:1',
            'total_rooms'     => 'required|integer|min:1',
            'image'           => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('hotel-rooms', 'public');
        }

        HotelRoom::create([
            'hotel_id'        => $hotel->id,
            'name'            => $request->name,
            'description'     => $request->description,
            'capacity'        => $request->capacity,
            'price_per_night' => $request->price_per_night,
            'total_rooms'     => $request->total_rooms,
            'image'           => $imagePath,
            'is_available'    => true,
        ]);

        return redirect()->route('hotel.vendor.dashboard')->with('success', 'Room added!');
    }

    public function deleteRoom(HotelRoom $room)
    {
        $hotel = Hotel::where('user_id', Auth::id())->firstOrFail();
        if ($room->hotel_id !== $hotel->id) abort(403);
        if ($room->image) Storage::disk('public')->delete($room->image);
        $room->delete();
        return redirect()->route('hotel.vendor.dashboard')->with('success', 'Room deleted!');
    }

    public function vendorUpdateBooking(Request $request, HotelBooking $booking)
    {
        $hotel = Hotel::where('user_id', Auth::id())->firstOrFail();
        if ($booking->hotel_id !== $hotel->id) abort(403);
        $request->validate(['status' => 'required|in:pending,confirmed,cancelled,completed']);
        $booking->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Booking updated!');
    }

    // ==================== ADMIN ====================

    public function adminIndex()
    {
        $hotels = Hotel::with('city', 'user', 'rooms')->latest()->paginate(15);
        return view('hotels.admin.index', compact('hotels'));
    }

    public function adminCreate()
    {
        $cities  = City::all();
        $vendors = \App\Models\User::where('role', 'vendor')->get();
        return view('hotels.admin.create', compact('cities', 'vendors'));
    }

    public function adminStore(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'address'     => 'required|string',
            'city_id'     => 'required|exists:cities,id',
            'star_rating' => 'required|in:1,2,3,4,5',
            'user_id'     => 'required|exists:users,id',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('hotels', 'public');
        }

        Hotel::create([
            'user_id'     => $request->user_id,
            'city_id'     => $request->city_id,
            'name'        => $request->name,
            'description' => $request->description,
            'address'     => $request->address,
            'phone'       => $request->phone,
            'email'       => $request->email,
            'star_rating' => $request->star_rating,
            'cover_image' => $coverPath,
            'status'      => 'approved',
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return redirect()->route('admin.hotels.index')->with('success', 'Hotel added!');
    }

    public function adminShow(Hotel $hotel)
    {
        $hotel->load(['city', 'rooms', 'user', 'bookings.user', 'bookings.room']);
        $cities = City::all();
        return view('hotels.admin.show', compact('hotel', 'cities'));
    }

    public function adminEdit(Hotel $hotel)
    {
        $cities  = City::all();
        $vendors = \App\Models\User::where('role', 'vendor')->get();
        return view('hotels.admin.edit', compact('hotel', 'cities', 'vendors'));
    }

    public function adminUpdate(Request $request, Hotel $hotel)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'address'     => 'required|string',
            'city_id'     => 'required|exists:cities,id',
            'star_rating' => 'required|in:1,2,3,4,5',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($hotel->cover_image) Storage::disk('public')->delete($hotel->cover_image);
            $hotel->cover_image = $request->file('cover_image')->store('hotels', 'public');
        }

        $hotel->update([
            'city_id'     => $request->city_id,
            'name'        => $request->name,
            'description' => $request->description,
            'address'     => $request->address,
            'phone'       => $request->phone,
            'email'       => $request->email,
            'star_rating' => $request->star_rating,
            'status'      => $request->status,
            'is_featured' => $request->boolean('is_featured'),
            'cover_image' => $hotel->cover_image,
        ]);

        return redirect()->route('admin.hotels.show', $hotel)->with('success', 'Hotel updated!');
    }

    public function adminDestroy(Hotel $hotel)
    {
        if ($hotel->cover_image) Storage::disk('public')->delete($hotel->cover_image);
        $hotel->delete();
        return redirect()->route('admin.hotels.index')->with('success', 'Hotel deleted!');
    }

    public function adminApprove(Hotel $hotel)
    {
        $hotel->update(['status' => 'approved']);
        return back()->with('success', 'Hotel approved!');
    }

    public function adminReject(Hotel $hotel)
    {
        $hotel->update(['status' => 'rejected']);
        return back()->with('success', 'Hotel rejected.');
    }

    public function adminToggleFeatured(Hotel $hotel)
    {
        $hotel->update(['is_featured' => !$hotel->is_featured]);
        return back()->with('success', 'Featured status updated!');
    }

    public function adminAddRoom(Request $request, Hotel $hotel)
    {
        $request->validate([
            'name'            => 'required|string|max:100',
            'capacity'        => 'required|integer|min:1',
            'price_per_night' => 'required|numeric|min:1',
            'total_rooms'     => 'required|integer|min:1',
            'image'           => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('hotel-rooms', 'public');
        }

        HotelRoom::create([
            'hotel_id'        => $hotel->id,
            'name'            => $request->name,
            'description'     => $request->description,
            'capacity'        => $request->capacity,
            'price_per_night' => $request->price_per_night,
            'total_rooms'     => $request->total_rooms,
            'image'           => $imagePath,
            'is_available'    => true,
        ]);

        return redirect()->route('admin.hotels.show', $hotel)->with('success', 'Room added!');
    }

    public function adminDeleteRoom(Hotel $hotel, HotelRoom $room)
    {
        if ($room->image) Storage::disk('public')->delete($room->image);
        $room->delete();
        return redirect()->route('admin.hotels.show', $hotel)->with('success', 'Room deleted!');
    }

    public function adminBookings()
    {
        $bookings = HotelBooking::with('user', 'hotel', 'room')->latest()->paginate(15);
        return view('hotels.admin.bookings', compact('bookings'));
    }

    public function adminUpdateBooking(Request $request, HotelBooking $booking)
    {
        $request->validate(['status' => 'required|in:pending,confirmed,cancelled,completed']);
        $booking->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Booking status updated!');
    }
}
