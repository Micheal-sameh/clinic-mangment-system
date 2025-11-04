# TODO: Modify Users Index for Admin/Secretary and Create Patients Index

## Tasks
- [x] Update UserController.php: Modify index() to filter for 'admin' or 'secretary' roles, add patientsIndex() method for 'patient' role, pass 'userType' to view.
- [x] Update UserService.php: Modify index() to accept role filter parameter.
- [x] Update routes/web.php: Add new route for patients.index pointing to patientsIndex method.
- [x] Modify resources/views/users/index.blade.php: Add "Role" column to explicitly declare each user's role, use 'userType' for context.
- [x] Test the new routes and verify filtering and display work correctly.
