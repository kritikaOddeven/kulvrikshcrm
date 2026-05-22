# Import/Export Functionality Documentation

## Overview
This import/export functionality allows you to bulk import and export geographical data including countries, states, cities, districts, talukas, and villages.

## Features
- **Import Data**: Upload CSV files to bulk import geographical data
- **Export Data**: Download existing data for reference or backup
- **Template Downloads**: Get properly formatted CSV templates
- **Validation**: Comprehensive data validation with error reporting
- **Relationship Support**: Maintains proper relationships between different geographical entities

## Access
Navigate to **Settings > Import/Export Data** in the admin panel.

## Data Structure

### Countries
- `name` (string): Country name
- `phonecode` (integer): Country phone code

### States
- `name` (string): State name
- `country_id` (integer): Reference to countries table

### Cities
- `name` (string): City name
- `state_id` (integer): Reference to states table

### Districts
- `name` (string): District name
- `state_id` (integer): Reference to states table

### Talukas
- `name` (string): Taluka name
- `city_id` (integer): Reference to cities table

### Villages
- `name` (string): Village name
- `taluka_id` (integer): Reference to talukas table

## How to Use

### Step 1: Download Template
1. Click on "Download Template" for the data type you want to import
2. This will download a CSV file with proper headers and example data

### Step 2: Export Reference Data
1. Use the export buttons to download existing data
2. This helps you get the correct IDs for foreign key relationships
3. For example, when importing states, export countries first to get valid country IDs

### Step 3: Fill Your Data
1. Open the downloaded template in Excel or any CSV editor
2. Fill in your data following the template format
3. Ensure all foreign key IDs exist in the database

### Step 4: Upload and Import
1. Select the data type from the dropdown
2. Choose your filled CSV file
3. Click "Upload CSV" to start the import process

## Important Notes

### Foreign Key Relationships
- **States**: Must have valid `country_id` that exists in countries table
- **Cities**: Must have valid `state_id` that exists in states table
- **Districts**: Must have valid `state_id` that exists in states table
- **Talukas**: Must have valid `city_id` that exists in cities table
- **Villages**: Must have valid `taluka_id` that exists in talukas table

### Data Validation
- All required fields must be filled
- Foreign key IDs must exist in their respective tables
- Duplicate entries will be updated, not created
- File size limit: 10MB
- Only CSV files are accepted

### Error Handling
- Import process validates each row individually
- Failed rows are reported with specific error messages
- Successful imports continue even if some rows fail
- Detailed error log is shown after import completion

## Example CSV Format

### Countries Template
```csv
name,phonecode
United States,1
India,91
```

### States Template
```csv
name,country_id
California,1
Maharashtra,91
```

### Cities Template
```csv
name,state_id
Los Angeles,1
Mumbai,91
```

## Troubleshooting

### Common Issues
1. **Foreign Key Errors**: Ensure all referenced IDs exist in the database
2. **File Format Errors**: Use the provided templates and ensure proper CSV formatting
3. **Validation Errors**: Check that all required fields are filled and data types are correct

### Getting Help
1. Always use the export functions to get reference data with correct IDs
2. Check the error messages for specific validation failures
3. Verify your CSV file format matches the downloaded template

## Technical Details

### Dependencies
- Laravel Framework
- League CSV Package (v9.26+)

### File Locations
- Controller: `app/Http/Controllers/Admin/ImportController.php`
- Views: `resources/views/admin/settings/import/`
- Routes: `routes/web.php` (under settings group)

### Database Tables
- `countries`
- `states`
- `cities`
- `districts`
- `talukas`
- `villages`

## Security
- CSRF protection enabled
- File upload validation
- Input sanitization
- Database transaction safety
