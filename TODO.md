# Reservation Index Filters Task

## Steps to Complete
- [x] Add date_from and date_to input fields to the filter form in resources/views/reservations/index.blade.php
- [x] Add search input field for patient name or phone in resources/views/reservations/index.blade.php
- [x] Update ReservationRepository index method to handle date range filter using whereBetween
- [x] Update ReservationRepository index method to handle search filter using whereHas on user relationship
- [ ] Test the new filters functionality
- [ ] Verify existing filters (today, history) still work
