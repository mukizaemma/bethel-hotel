<?php

use App\Livewire\Public\AboutPage;
use App\Livewire\Public\ActivitiesPage;
use App\Livewire\Public\ActivityShowPage;
use App\Livewire\Public\ApartmentLandingPage;
use App\Livewire\Public\ApartmentsPage;
use App\Livewire\Public\BlogPostPage;
use App\Livewire\Public\BookNowPage;
use App\Livewire\Public\ContactPage;
use App\Livewire\Public\EventsPage;
use App\Livewire\Public\MeetingRoomShowPage;
use App\Livewire\Public\FacilitiesPage;
use App\Livewire\Public\FacilityShowPage;
use App\Livewire\Public\GalleryPage;
use App\Livewire\Public\OurServicesPage;
use App\Livewire\Public\OurTeamPage;
use App\Livewire\Public\GuesthousePage;
use App\Livewire\Public\HomePage;
use App\Livewire\Public\PromotionsPage;
use App\Livewire\Public\RestaurantPage;
use App\Livewire\Public\ReviewShowPage;
use App\Livewire\Public\ReviewsPage;
use App\Livewire\Public\RoomShowPage;
use App\Livewire\Public\RoomsPage;
use App\Livewire\Public\SpaWellnessPage;
use App\Livewire\Public\TermsPage;
use App\Livewire\Public\TourShowPage;
use App\Livewire\Public\ToursPage;
use App\Livewire\Public\UpdatesPage;
use App\Livewire\Admin\AmenityIndex;
use App\Livewire\Admin\ContentManagementAbout;
use App\Livewire\Admin\ContentManagementContacts;
use App\Livewire\Admin\ContentManagementDashboard;
use App\Livewire\Admin\ContentManagementGallery;
use App\Livewire\Admin\ContentManagementPageHeroes;
use App\Livewire\Admin\ContentManagementReservations;
use App\Livewire\Admin\ContentManagementSeo;
use App\Livewire\Admin\ContentManagementSlideshow;
use App\Livewire\Admin\ContentManagementTerms;
use App\Livewire\Admin\FacilityManagementIndex;
use App\Livewire\Admin\ServiceManagementIndex;
use App\Livewire\Admin\TourActivityIndex;
use App\Livewire\Admin\UserManagementIndex;
use App\Livewire\Account\AccountBookingShow;
use App\Livewire\Account\AccountBookings;
use App\Livewire\Account\AccountDashboard;
use App\Livewire\Account\AccountPassword;
use App\Livewire\Account\AccountProfile;
use Illuminate\Support\Facades\Route;

// ============================================
// CONTENT MANAGEMENT DASHBOARD ROUTES
// Access: Super Admin (role_id=1) & Content Manager (role_id=2)
// ============================================
Route::middleware(['auth', 'admin'])->prefix('content-management')->name('content-management.')->group(function () {
    Route::get('/dashboard', ContentManagementDashboard::class)->name('dashboard');
    
    // Hotel Contacts
    Route::get('/contacts', ContentManagementContacts::class)->name('contacts');
    Route::post('/contacts/update', [App\Http\Controllers\ContentManagementController::class, 'updateContacts'])->name('contacts.update');
    
    // About Us
    Route::get('/about', ContentManagementAbout::class)->name('about');
    Route::post('/about/update', [App\Http\Controllers\ContentManagementController::class, 'updateAbout'])->name('about.update');
    
    // Terms and Conditions
    Route::get('/terms-conditions', ContentManagementTerms::class)->name('terms');
    Route::post('/terms-conditions/update', [App\Http\Controllers\ContentManagementController::class, 'updateTermsConditions'])->name('terms.update');
    
    // SEO Data
    Route::get('/seo-data', ContentManagementSeo::class)->name('seo');
    Route::get('/seo-data/{id}', [App\Http\Controllers\ContentManagementController::class, 'showSeoData'])->name('seo.show');
    Route::post('/seo-data/update', [App\Http\Controllers\ContentManagementController::class, 'updateSeoData'])->name('seo.update');
    Route::post('/seo-data/store', [App\Http\Controllers\ContentManagementController::class, 'updateSeoData'])->name('seo.store');
    
    // System Users: only admin@iremetech.com (see UserManagementController).
    Route::get('/users', UserManagementIndex::class)->name('users');
    Route::post('/users/store', [App\Http\Controllers\UserManagementController::class, 'store'])->name('users.store');
    Route::get('/users/{id}', [App\Http\Controllers\UserManagementController::class, 'show'])->name('users.show');
    Route::post('/users/{id}/update', [App\Http\Controllers\UserManagementController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [App\Http\Controllers\UserManagementController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{id}/verify-email', [App\Http\Controllers\UserManagementController::class, 'verifyEmail'])->name('users.verify-email');
    Route::post('/users/{id}/resend-verification', [App\Http\Controllers\UserManagementController::class, 'resendVerification'])->name('users.resend-verification');
    Route::post('/users/{id}/reset-password', [App\Http\Controllers\UserManagementController::class, 'resetPassword'])->name('users.reset-password');
    
    // Services - Full CRUD
    Route::get('/services', ServiceManagementIndex::class)->name('services');
    Route::post('/services/store', [App\Http\Controllers\ServiceManagementController::class, 'store'])->name('services.store');
    Route::get('/services/{id}', [App\Http\Controllers\ServiceManagementController::class, 'show'])->name('services.show');
    Route::post('/services/{id}/update', [App\Http\Controllers\ServiceManagementController::class, 'update'])->name('services.update');
    Route::delete('/services/{id}', [App\Http\Controllers\ServiceManagementController::class, 'destroy'])->name('services.destroy');
    Route::delete('/services/images/{id}', [App\Http\Controllers\ServiceManagementController::class, 'deleteImage'])->name('services.delete-image');
    
    // Rooms - Full CRUD (controller + Blade; avoids Livewire single-root constraint on this page)
    Route::get('/rooms', [App\Http\Controllers\RoomManagementController::class, 'index'])->name('rooms');
    Route::post('/rooms/store', [App\Http\Controllers\RoomManagementController::class, 'store'])->name('rooms.store');
    Route::get('/rooms/{id}', [App\Http\Controllers\RoomManagementController::class, 'show'])->name('rooms.show');
    Route::post('/rooms/{id}/update', [App\Http\Controllers\RoomManagementController::class, 'update'])->name('rooms.update');
    Route::delete('/rooms/{id}', [App\Http\Controllers\RoomManagementController::class, 'destroy'])->name('rooms.destroy');
    Route::delete('/rooms/images/{id}', [App\Http\Controllers\RoomManagementController::class, 'deleteImage'])->name('rooms.delete-image');
    Route::post('/rooms/{id}/images', [App\Http\Controllers\RoomManagementController::class, 'addImages'])->name('rooms.add-images');
    
    // Facilities - Full CRUD
    Route::get('/facilities', FacilityManagementIndex::class)->name('facilities');
    Route::post('/facilities/store', [App\Http\Controllers\FacilityManagementController::class, 'store'])->name('facilities.store');
    Route::get('/facilities/{id}', [App\Http\Controllers\FacilityManagementController::class, 'show'])->name('facilities.show');
    Route::post('/facilities/{id}/update', [App\Http\Controllers\FacilityManagementController::class, 'update'])->name('facilities.update');
    Route::delete('/facilities/{id}', [App\Http\Controllers\FacilityManagementController::class, 'destroy'])->name('facilities.destroy');
    Route::delete('/facilities/images/{id}', [App\Http\Controllers\FacilityManagementController::class, 'deleteImage'])->name('facilities.delete-image');
    Route::post('/facilities/{id}/images', [App\Http\Controllers\FacilityManagementController::class, 'addImages'])->name('facilities.add-images');
    
    // Amenities - Full CRUD
    Route::get('/amenities', AmenityIndex::class)->name('amenities');
    Route::post('/amenities/store', [App\Http\Controllers\AmenityController::class, 'store'])->name('amenities.store');
    Route::get('/amenities/{id}', [App\Http\Controllers\AmenityController::class, 'show'])->name('amenities.show');
    Route::post('/amenities/{id}/update', [App\Http\Controllers\AmenityController::class, 'update'])->name('amenities.update');
    Route::delete('/amenities/{id}', [App\Http\Controllers\AmenityController::class, 'destroy'])->name('amenities.destroy');
    
    // Tour Activities - Full CRUD
    Route::get('/tour-activities', TourActivityIndex::class)->name('tour-activities');
    Route::post('/tour-activities/store', [App\Http\Controllers\TourActivityController::class, 'store'])->name('tour-activities.store');
    Route::get('/tour-activities/{id}', [App\Http\Controllers\TourActivityController::class, 'show'])->name('tour-activities.show');
    Route::post('/tour-activities/{id}/update', [App\Http\Controllers\TourActivityController::class, 'update'])->name('tour-activities.update');
    Route::delete('/tour-activities/{id}', [App\Http\Controllers\TourActivityController::class, 'destroy'])->name('tour-activities.destroy');
    Route::delete('/tour-activities/images/{id}', [App\Http\Controllers\TourActivityController::class, 'deleteImage'])->name('tour-activities.delete-image');

    // Why Choose Us
    Route::get('/why-choose-us', [App\Http\Controllers\WhyChooseUsController::class, 'index'])->name('why-choose-us.index');
    Route::post('/why-choose-us/store', [App\Http\Controllers\WhyChooseUsController::class, 'store'])->name('why-choose-us.store');
    Route::get('/why-choose-us/{id}', [App\Http\Controllers\WhyChooseUsController::class, 'show'])->name('why-choose-us.show');
    Route::post('/why-choose-us/{id}/update', [App\Http\Controllers\WhyChooseUsController::class, 'update'])->name('why-choose-us.update');
    Route::delete('/why-choose-us/{id}', [App\Http\Controllers\WhyChooseUsController::class, 'destroy'])->name('why-choose-us.destroy');

    // Attractions (nearby places / POIs)
    Route::get('/attractions', [App\Http\Controllers\AttractionController::class, 'index'])->name('attractions.index');
    Route::post('/attractions/store', [App\Http\Controllers\AttractionController::class, 'store'])->name('attractions.store');
    Route::get('/attractions/{id}', [App\Http\Controllers\AttractionController::class, 'show'])->name('attractions.show');
    Route::post('/attractions/{id}/update', [App\Http\Controllers\AttractionController::class, 'update'])->name('attractions.update');
    Route::delete('/attractions/{id}', [App\Http\Controllers\AttractionController::class, 'destroy'])->name('attractions.destroy');
    
    // Gallery
    Route::get('/gallery', ContentManagementGallery::class)->name('gallery');
    Route::post('/gallery/store', [App\Http\Controllers\ContentManagementController::class, 'storeGallery'])->name('gallery.store');
    
    // Slideshow
    Route::get('/slideshow', ContentManagementSlideshow::class)->name('slideshow');
    Route::post('/slideshow/store', [App\Http\Controllers\ContentManagementController::class, 'storeSlide'])->name('slideshow.store');
    Route::post('/slideshow/{slide}/update', [App\Http\Controllers\ContentManagementController::class, 'updateSlide'])->name('slideshow.update');
    Route::delete('/slideshow/{slide}', [App\Http\Controllers\ContentManagementController::class, 'deleteSlide'])->name('slideshow.destroy');
    
    // Page Heroes
    Route::get('/page-heroes', ContentManagementPageHeroes::class)->name('page-heroes');
    Route::post('/page-heroes/{id}/update', [App\Http\Controllers\ContentManagementController::class, 'updatePageHero'])->name('page-heroes.update');
    
    // Reservations (rooms + facilities, via tabs)
    Route::get('/reservations', ContentManagementReservations::class)->name('reservations');
    Route::get('/reservations/{id}', [App\Http\Controllers\ContentManagementController::class, 'showReservation'])->name('reservations.show');
    Route::post('/reservations/{id}/reply', [App\Http\Controllers\ContentManagementController::class, 'replyReservation'])->name('reservations.reply');
});

// Legacy Admin Routes (keeping for backward compatibility)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');
    Route::get('/logouts', [App\Http\Controllers\AdminController::class, 'logouts'])->name('logouts');
    Route::get('/Users', [App\Http\Controllers\AdminController::class, 'users'])->name('users');
    Route::get('/Users/{id}', [App\Http\Controllers\AdminController::class, 'makeAdmin'])->name('makeAdmin');
    Route::get('/deleteUser/{id}', [App\Http\Controllers\AdminController::class, 'deleteUser'])->name('deleteUser');

 
    Route::get('/Comments', [App\Http\Controllers\AdminController::class, 'blogsComment'])->name('blogsComment');
    Route::post('/Comment/approve/{comment}', [App\Http\Controllers\AdminController::class, 'commentApprove'])->name('commentApprove');
    Route::get('/CommentDelete/{id}', [App\Http\Controllers\AdminController::class, 'destroyBlogComment'])->name('destroyBlogComment');

    Route::get('/Subscribers', [App\Http\Controllers\AdminController::class, 'subscribers'])->name('subscribers');
    Route::get('/Subscribers/{id}', [App\Http\Controllers\AdminController::class, 'destroySub'])->name('destroySub');
    Route::get('/delete-booking/{id}', [App\Http\Controllers\AdminController::class, 'destroyBooking'])->name('destroyBooking');
    Route::post('/reply-booking/{id}', [App\Http\Controllers\AdminController::class, 'replyBooking'])->name('replyBooking');

    Route::get('/getMessages', [App\Http\Controllers\AdminController::class, 'getMessages'])->name('getMessages');
    Route::post('/reply-message/{id}', [App\Http\Controllers\AdminController::class, 'replyMessage'])->name('replyMessage');
    Route::get('/deleteMessages/{id}', [App\Http\Controllers\AdminController::class, 'deleteMessages'])->name('deleteMessages');

    
    Route::get('/setting',[App\Http\Controllers\SettingsController::class,'setting'])->name('setting');
    Route::post('/saveSetting',[App\Http\Controllers\SettingsController::class,'saveSetting'])->name('saveSetting');
    Route::post('/setting/footer-delivered-by',[App\Http\Controllers\SettingsController::class,'updateFooterDeliveredBy'])->name('setting.footer-delivered-by.update');
    Route::post('/setting/channel-links', [App\Http\Controllers\SettingsController::class, 'saveChannelLinks'])->name('setting.channel-links.update');
    Route::post('/setting/keywords',[App\Http\Controllers\SettingsController::class,'updateKeywords'])->name('setting.keywords.update');
    
    Route::get('/homePage',[App\Http\Controllers\SettingsController::class,'homePage'])->name('homePage');
    Route::post('/saveHome',[App\Http\Controllers\SettingsController::class,'saveHome'])->name('saveHome');
    
    Route::get('/aboutPage',[App\Http\Controllers\SettingsController::class,'aboutPage'])->name('aboutPage');
    Route::post('/saveAbout',[App\Http\Controllers\SettingsController::class,'saveAbout'])->name('saveAbout');

    Route::get('/eventsPage',[App\Http\Controllers\PagesController::class,'eventsPage'])->name('eventsPage');
    Route::post('/saveEvent',[App\Http\Controllers\PagesController::class,'saveEvent'])->name('saveEvent');
    Route::post('/addEventImage', [App\Http\Controllers\PagesController::class, 'addEventImage'])->name('addEventImage');
    Route::post('/updateEventImage/{id}', [App\Http\Controllers\PagesController::class, 'updateEventImage'])->name('updateEventImage');
    Route::post('/reorderEventImage/{id}', [App\Http\Controllers\PagesController::class, 'reorderEventImage'])->name('reorderEventImage');
    Route::get('/deleteEventImage/{id}', [App\Http\Controllers\PagesController::class, 'deleteEventImage'])->name('deleteEventImage');

    Route::post('/saveMeetingRoom/{id}', [App\Http\Controllers\PagesController::class, 'saveMeetingRoom'])->name('saveMeetingRoom');
    Route::post('/addMeetingRoom', [App\Http\Controllers\PagesController::class, 'addMeetingRoom'])->name('addMeetingRoom');
    Route::get('/deleteMeetingRoom/{id}', [App\Http\Controllers\PagesController::class, 'deleteMeetingRoom'])->name('deleteMeetingRoom');
    Route::post('/addMeetingRoomImage', [App\Http\Controllers\PagesController::class, 'addMeetingRoomImage'])->name('addMeetingRoomImage');
    Route::post('/updateMeetingRoomImage/{id}', [App\Http\Controllers\PagesController::class, 'updateMeetingRoomImage'])->name('updateMeetingRoomImage');
    Route::post('/reorderMeetingRoomImage/{id}', [App\Http\Controllers\PagesController::class, 'reorderMeetingRoomImage'])->name('reorderMeetingRoomImage');
    Route::get('/deleteMeetingRoomImage/{id}', [App\Http\Controllers\PagesController::class, 'deleteMeetingRoomImage'])->name('deleteMeetingRoomImage');

    Route::get('/resto', [App\Http\Controllers\PagesController::class, 'resto'])->name('resto');
    Route::post('/saveResto/{id}', [App\Http\Controllers\PagesController::class, 'saveResto'])->name('saveResto');
    Route::post('/addRestoImage', [App\Http\Controllers\PagesController::class, 'addRestoImage'])->name('addRestoImage');
    Route::post('/updateRestoImage/{id}', [App\Http\Controllers\PagesController::class, 'updateRestoImage'])->name('updateRestoImage');
    Route::post('/reorderRestoImage/{id}', [App\Http\Controllers\PagesController::class, 'reorderRestoImage'])->name('reorderRestoImage');
    Route::get('/deleteRestoImage/{id}', [App\Http\Controllers\PagesController::class, 'deleteRestoImage'])->name('deleteRestoImage');
    Route::post('/addRestoCuisine', [App\Http\Controllers\PagesController::class, 'addRestoCuisine'])->name('addRestoCuisine');
    Route::post('/updateRestoCuisine/{id}', [App\Http\Controllers\PagesController::class, 'updateRestoCuisine'])->name('updateRestoCuisine');
    Route::post('/reorderRestoCuisine/{id}', [App\Http\Controllers\PagesController::class, 'reorderRestoCuisine'])->name('reorderRestoCuisine');
    Route::get('/deleteRestoCuisine/{id}', [App\Http\Controllers\PagesController::class, 'deleteRestoCuisine'])->name('deleteRestoCuisine');

        
    // Categories
    Route::get('/getCategories', [App\Http\Controllers\CategoriesController::class, 'index'])->name('getCategories');
    Route::post('/postCategory', [App\Http\Controllers\CategoriesController::class, 'store'])->name('postCategory');
    Route::get('/editCategory/{id}', [App\Http\Controllers\CategoriesController::class, 'edit'])->name('editCategory');
    Route::post('/updateCategory/{id}', [App\Http\Controllers\CategoriesController::class, 'update'])->name('updateCategory');
    Route::get('/deleteCategory/{id}', [App\Http\Controllers\CategoriesController::class, 'destroy'])->name('deleteCategory');
        
    // BLogs
    Route::get('/getBlogs', [App\Http\Controllers\BlogsController::class, 'index'])->name('getBlogs');
    Route::post('/saveBlog', [App\Http\Controllers\BlogsController::class, 'store'])->name('saveBlog');
    Route::get('/blog/{id}', [App\Http\Controllers\BlogsController::class, 'edit'])->name('editBlog');
    Route::get('/blogView/{id}', [App\Http\Controllers\BlogsController::class, 'view'])->name('viewBlog');
    Route::post('/updateBlog/{id}', [App\Http\Controllers\BlogsController::class, 'update'])->name('updateBlog');
    Route::get('/deleteBlog/{id}', [App\Http\Controllers\BlogsController::class, 'destroy'])->name('deleteBlog');
    Route::get('/Blog/{blog}/publish', [App\Http\Controllers\BlogsController::class, 'publish'])->name('publishBlog');

    // Team members
    Route::get('/staff', [App\Http\Controllers\TeamsController::class, 'index'])->name('staff');
    Route::post('/saveStaff', [App\Http\Controllers\TeamsController::class, 'store'])->name('saveStaff');
    Route::get('/editStaff/{id}', [App\Http\Controllers\TeamsController::class, 'edit'])->name('editStaff');
    Route::post('/updateStaff/{id}', [App\Http\Controllers\TeamsController::class, 'update'])->name('updateStaff');
    Route::get('/deleteStaff/{id}', [App\Http\Controllers\TeamsController::class, 'destroy'])->name('deleteStaff');


    // Services
    Route::get('/getServices', [App\Http\Controllers\ServicesController::class, 'index'])->name('getServices');
    Route::post('/storeService', [App\Http\Controllers\ServicesController::class, 'store'])->name('storeService');
    Route::get('/EditService/{id}', [App\Http\Controllers\ServicesController::class, 'edit'])->name('editService');
    Route::post('/UpdateService/{id}', [App\Http\Controllers\ServicesController::class, 'update'])->name('updateService');
    Route::get('/DeleteService/{id}', [App\Http\Controllers\ServicesController::class, 'destroy'])->name('deleteService');

    // Rooms
    Route::get('/getRooms', [App\Http\Controllers\RoomsController::class, 'index'])->name('getRooms');
    Route::post('/storeRoom', [App\Http\Controllers\RoomsController::class, 'store'])->name('storeRoom');
    Route::get('/editRoom/{id}', [App\Http\Controllers\RoomsController::class, 'edit'])->name('editRoom');
    Route::post('/updateRoom/{id}', [App\Http\Controllers\RoomsController::class, 'update'])->name('updateRoom');
    Route::get('/deleteRoom/{id}', [App\Http\Controllers\RoomsController::class, 'destroy'])->name('deleteRoom');

    Route::post('/addRoomImage', [App\Http\Controllers\RoomsController::class, 'addRoomImage'])->name('addRoomImage');
    Route::get('/deleteRoomImage/{id}', [App\Http\Controllers\RoomsController::class, 'deleteRoomImage'])->name('deleteRoomImage');

    // Facilities
    Route::get('/getFacilities', [App\Http\Controllers\FacilitiesController::class, 'index'])->name('getFacilities');
    Route::post('/storeFacility', [App\Http\Controllers\FacilitiesController::class, 'store'])->name('storeFacility');
    Route::get('/editFacility/{id}', [App\Http\Controllers\FacilitiesController::class, 'edit'])->name('editFacility');
    Route::post('/updateFacility/{id}', [App\Http\Controllers\FacilitiesController::class, 'update'])->name('updateFacility');
    Route::get('/deleteFacility/{id}', [App\Http\Controllers\FacilitiesController::class, 'destroy'])->name('deleteFacility');

    Route::post('/addFacilityImage', [App\Http\Controllers\FacilitiesController::class, 'addFacilityImage'])->name('addFacilityImage');
    Route::get('/deleteFacilityImage/{id}', [App\Http\Controllers\FacilitiesController::class, 'deleteFacilityImage'])->name('deleteFacilityImage');

    // Trips
    Route::get('/getTrips', [App\Http\Controllers\TripsController::class, 'index'])->name('getTrips');
    Route::post('/storeTrip', [App\Http\Controllers\TripsController::class, 'store'])->name('storeTrip');
    Route::get('/editTrip/{id}', [App\Http\Controllers\TripsController::class, 'edit'])->name('editTrip');
    Route::post('/updateTrip/{id}', [App\Http\Controllers\TripsController::class, 'update'])->name('updateTrip');
    Route::get('/deleteTrip/{id}', [App\Http\Controllers\TripsController::class, 'destroy'])->name('deleteTrip');

    Route::post('/addTripImage', [App\Http\Controllers\TripsController::class, 'addTripImage'])->name('addTripImage');
    Route::get('/deleteTripImage/{id}', [App\Http\Controllers\TripsController::class, 'deleteTripImage'])->name('deleteTripImage');

    // Tours
    Route::get('/getTours', [App\Http\Controllers\ToursController::class, 'index'])->name('getTours');
    Route::post('/storeTour', [App\Http\Controllers\ToursController::class, 'store'])->name('storeTour');
    Route::get('/editTour/{id}', [App\Http\Controllers\ToursController::class, 'edit'])->name('editTour');
    Route::post('/updateTour/{id}', [App\Http\Controllers\ToursController::class, 'update'])->name('updateTour');
    Route::get('/deleteTour/{id}', [App\Http\Controllers\ToursController::class, 'destroy'])->name('deleteTour');
    Route::post('/addTourImage', [App\Http\Controllers\ToursController::class, 'addTourImage'])->name('addTourImage');
    Route::get('/deleteTourImage/{id}', [App\Http\Controllers\ToursController::class, 'deleteTourImage'])->name('deleteTourImage');

    // Promotions
    Route::get('/getPromotions', [App\Http\Controllers\PromotionsController::class, 'index'])->name('getPromotions');
    Route::post('/storePromotion', [App\Http\Controllers\PromotionsController::class, 'store'])->name('storePromotion');
    Route::get('/editPromotion/{id}', [App\Http\Controllers\PromotionsController::class, 'edit'])->name('editPromotion');
    Route::post('/updatePromotion/{id}', [App\Http\Controllers\PromotionsController::class, 'update'])->name('updatePromotion');
    Route::get('/deletePromotion/{id}', [App\Http\Controllers\PromotionsController::class, 'destroy'])->name('deletePromotion');
    // Projects
    Route::get('/getPosts', [App\Http\Controllers\OpportunitiesController::class, 'index'])->name('getPosts');
    Route::post('/storePost', [App\Http\Controllers\OpportunitiesController::class, 'store'])->name('storePost');
    Route::get('/EditPost/{id}', [App\Http\Controllers\OpportunitiesController::class, 'edit'])->name('editPost');
    Route::post('/UpdatePost/{id}', [App\Http\Controllers\OpportunitiesController::class, 'update'])->name('updatePost');
    Route::get('/DeletePost/{id}', [App\Http\Controllers\OpportunitiesController::class, 'destroy'])->name('deletePost');
    // Route::get('/DeleteallProjects', [App\Http\Controllers\OpportunitiesController::class, 'deleteAllProjects'])->name('deleteAllProjects');


    // Gallery
    Route::get('/slides', [App\Http\Controllers\SlidesController::class, 'index'])->name('slides');
    Route::post('/saveSlide', [App\Http\Controllers\SlidesController::class, 'store'])->name('saveSlide');
    Route::get('/editSlide/{id}', [App\Http\Controllers\SlidesController::class, 'edit'])->name('editSlide');
    Route::post('/updateSlide/{id}', [App\Http\Controllers\SlidesController::class, 'update'])->name('updateSlide');
    Route::get('/destroySlide/{id}', [App\Http\Controllers\SlidesController::class, 'destroy'])->name('destroySlide');

    // Images
    Route::get('/images', [App\Http\Controllers\ImagesController::class, 'index'])->name('images');
    Route::post('/saveImage', [App\Http\Controllers\ImagesController::class, 'store'])->name('saveImage');
    Route::get('/editImage/{id}', [App\Http\Controllers\ImagesController::class, 'edit'])->name('editImage');
    Route::post('/updateImage/{id}', [App\Http\Controllers\ImagesController::class, 'update'])->name('updateImage');
    Route::get('/destroyImage/{id}', [App\Http\Controllers\ImagesController::class, 'destroy'])->name('destroyImage');
    // Gallery
    Route::get('/getPartners', [App\Http\Controllers\PartnersController::class, 'index'])->name('getPartners');
    Route::post('/savePartner', [App\Http\Controllers\PartnersController::class, 'store'])->name('savePartner');
    Route::get('/editPartner/{id}', [App\Http\Controllers\PartnersController::class, 'edit'])->name('editPartner');
    Route::post('/updatePartner/{id}', [App\Http\Controllers\PartnersController::class, 'update'])->name('updatePartner');
    Route::get('/destroyPartner/{id}', [App\Http\Controllers\PartnersController::class, 'destroy'])->name('destroyPartner');

    // Gallery
    Route::get('/getImages', [App\Http\Controllers\SlidesController::class, 'getImages'])->name('getImages');
    Route::post('/saveGallery', [App\Http\Controllers\SlidesController::class, 'saveGallery'])->name('saveGallery');
    Route::get('/editGallery/{id}', [App\Http\Controllers\SlidesController::class, 'editGallery'])->name('editGallery');
    Route::post('/updateGallery/{id}', [App\Http\Controllers\SlidesController::class, 'updateGallery'])->name('updateGallery');
    Route::get('/destroyImage/{id}', [App\Http\Controllers\SlidesController::class, 'destroyImage'])->name('destroyImage');
    

});

// Public site: Livewire full-page components + Livewire navigate (see layouts.frontbase)
Route::get('/sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', function () {
    $sitemapUrl = url('/sitemap.xml');
    $content = <<<TXT
User-agent: *
Allow: /

Disallow: /admin
Disallow: /dashboard
Disallow: /account
Disallow: /content-management
Disallow: /Signin
Disallow: /getSignup
Disallow: /forgot-password
Disallow: /reset-password
Disallow: /verify-email
Disallow: /handover

Sitemap: {$sitemapUrl}
TXT;

    return response($content, 200)->header('Content-Type', 'text/plain; charset=UTF-8');
})->name('robots');

Route::get('/', HomePage::class)->name('home');
Route::get('/about-us', AboutPage::class)->name('about');
Route::get('/our-services', OurServicesPage::class)->name('our-services');
Route::get('/our-rooms', RoomsPage::class)->name('rooms');
Route::get('/our-apartments', ApartmentsPage::class)->name('apartments');
Route::get('/our-rooms/{slug}', RoomShowPage::class)->name('room');
Route::get('/dining', RestaurantPage::class)->name('dining');
Route::get('/our-team', OurTeamPage::class)->name('our-team');
Route::get('/our-updates', UpdatesPage::class)->name('updates');
Route::get('/our-updates/{slug}', BlogPostPage::class)->name('update');
Route::get('/tours', ToursPage::class)->name('tours');
Route::get('/tour/{slug}', TourShowPage::class)->name('tour');
Route::get('/gallery', GalleryPage::class)->name('gallery');
Route::get('/contact', ContactPage::class)->name('contact');
Route::post('/contact/enquiry', [App\Http\Controllers\HomeController::class, 'sendMessage'])->name('contact.enquiry');
Route::post('/contact/proposal', [App\Http\Controllers\HomeController::class, 'submitProposal'])->name('contact.proposal');
Route::get('/promotions', PromotionsPage::class)->name('promotions');
Route::get('/apartment', ApartmentLandingPage::class)->name('apartment');
Route::get('/guesthouse', GuesthousePage::class)->name('guesthouse');
Route::get('/facilities', FacilitiesPage::class)->name('facilities');
Route::get('/facilities/{slug}', FacilityShowPage::class)->name('facility');
Route::get('/activities', ActivitiesPage::class)->name('activities');
Route::get('/activities/{slug}', ActivityShowPage::class)->name('activity');
Route::get('/meetings-events', EventsPage::class)->name('meetings-events');
Route::get('/meetings-events/{slug}', MeetingRoomShowPage::class)
    ->where('slug', '[a-z0-9]+(?:-[a-z0-9]+)*')
    ->name('meetings-events.room');
Route::get('/spa-wellness', SpaWellnessPage::class)->name('spa-wellness');
Route::get('/terms-and-conditions', TermsPage::class)->name('terms');

Route::get('/reviews', ReviewsPage::class)->name('reviews');
Route::get('/reviews/{id}', ReviewShowPage::class)->name('review');

/** Client handover & user guide (noindex; not a Livewire page) */
Route::view('/handover', 'frontend.handover')->name('handover');

Route::get('/admin/login', [App\Http\Controllers\HomeController::class, 'adminLogin'])->name('adminLogin');
Route::get('/user/account', [App\Http\Controllers\HomeController::class, 'newAccount'])->name('newAccount');
Route::post('/createAccount', [App\Http\Controllers\HomeController::class, 'createAccount'])->name('createAccount');

Route::get('/book-now', BookNowPage::class)->name('connect');

// Normal user (guest role) account — bookings & profile
Route::middleware(['auth', 'normaluser'])->prefix('account')->name('account.')->group(function () {
    Route::get('/', AccountDashboard::class)->name('dashboard');
    Route::get('/profile', AccountProfile::class)->name('profile');
    Route::get('/bookings', AccountBookings::class)->name('bookings');
    Route::get('/bookings/{booking}', AccountBookingShow::class)->name('bookings.show');
    Route::get('/password', AccountPassword::class)->name('password');
});


// user sign up

Route::get('/getSignup', [App\Http\Controllers\HomeController::class, 'getSignup'])->name('getSignup');
Route::post('/Signup', [App\Http\Controllers\HomeController::class, 'signup'])->name('signup');
Route::get('/Signin', [App\Http\Controllers\HomeController::class, 'signin'])->name('signin');
Route::get('/logouts', [App\Http\Controllers\HomeController::class, 'logouts'])->name('logouts');
Route::post('/registerNow', [App\Http\Controllers\HomeController::class, 'registerNow'])->name('registerNow');

// Email Verification Routes (Public)
Route::get('/verify-email/{token}', [App\Http\Controllers\Auth\EmailVerificationController::class, 'verify'])->name('verify.email');
Route::post('/resend-verification', [App\Http\Controllers\Auth\EmailVerificationController::class, 'resend'])->name('resend.verification');

// Password Reset Routes (using Fortify, but adding custom routes if needed)
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');
