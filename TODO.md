# TODO: Complete Procedures CRUD

## Tasks
- [x] Create show.blade.php view for procedures
- [x] Fix delete flash message in ProcedureController
- [x] Test show functionality (routes verified)
- [x] Verify delete flash message works correctly (fixed)

## Information Gathered
- ProcedureController has show method but no corresponding view
- Delete method uses 'success' flash message but index checks for 'message'
- Routes include procedures.show route
- Index view has links to show page

## Plan
1. Create resources/views/procedures/show.blade.php with procedure details display
2. Update ProcedureController delete method to use 'message' instead of 'success'
3. Test the implementation
