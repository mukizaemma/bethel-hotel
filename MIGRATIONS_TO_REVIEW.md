# Migrations Review - Potentially Unused

## ⚠️ Review Before Deleting

The following migrations might not be needed based on the new system requirements. **Please verify they are not used in frontend views before deleting.**

### 1. Trips/Tours (Replaced by Tour Activities)
These are replaced by the new `tour_activities` table:
- `database/migrations/994_create_trips_table.php`
- `database/migrations/995_create_tripimages_table.php`
- `database/migrations/94_create_tours_table.php`
- `database/migrations/97_create_tourimages_table.php`

**Action**: Check if `Trip` and `Tour` models are used in `HomeController` or frontend views. If not, these can be deleted.

### 2. Events (Not Mentioned in Requirements)
- `database/migrations/34_create_events_table.php`
- `database/migrations/991_create_eventimages_table.php`
- `database/migrations/99_create_eventpages_table.php`

**Action**: Check if events are displayed on the frontend. If not, these can be deleted.

### 3. Restaurants (Not Mentioned in Requirements)
- `database/migrations/98_create_restaurants_table.php`
- `database/migrations/99_create_restoimages_table.php`

**Action**: Check if restaurants are displayed on the frontend. If not, these can be deleted.

### 4. Teams (Not Mentioned in Requirements)
- `database/migrations/16_create_teams_table.php`

**Action**: Check if teams are displayed on the frontend. If not, this can be deleted.

### 5. Programs (Might Be Used)
- `database/migrations/14_create_programs_table.php`

**Action**: This might be used in the frontend. Check `HomeController` for usage before deleting.

## ✅ Keep These Migrations

These are actively used in the new system:
- All role and user related migrations
- Rooms, bookings, reservations migrations
- Services, facilities, amenities migrations
- Galleries, slides migrations
- Settings, abouts migrations
- Blogs, categories, blog_comments (if blog is still used)
- All new migrations created (expenses, payments, invoices, etc.)
- Tour activities migrations (new)

## 🔍 How to Check

1. Search for model usage:
```bash
grep -r "Trip\|Tour\|Event\|Restaurant\|Team\|Program" app/Http/Controllers/
grep -r "Trip\|Tour\|Event\|Restaurant\|Team\|Program" resources/views/
```

2. Check database for existing data:
```sql
SELECT COUNT(*) FROM trips;
SELECT COUNT(*) FROM tours;
SELECT COUNT(*) FROM events;
SELECT COUNT(*) FROM restaurants;
SELECT COUNT(*) FROM teams;
SELECT COUNT(*) FROM programs;
```

3. If tables are empty and not used in code, safe to delete migrations.

## 🗑️ Safe Deletion Process

1. **Backup your database first!**
2. Check for usage in code (see above)
3. Check for data in database
4. If unused and empty, delete migration files
5. Run `php artisan migrate:status` to verify

## 📝 Note

Even if migrations are deleted, if the tables already exist in your database, they won't be automatically dropped. You would need to:
1. Create a new migration to drop the tables
2. Or manually drop them from the database

Example migration to drop unused tables:
```php
Schema::dropIfExists('trips');
Schema::dropIfExists('tripimages');
Schema::dropIfExists('tours');
Schema::dropIfExists('tourimages');
// etc.
```
