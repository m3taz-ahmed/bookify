# Multiple Shifts Feature - User Guide

## Overview
The Multiple Shifts feature allows you to assign multiple working periods to an employee for the same day. This is useful when an employee works split shifts (e.g., morning and evening with a break in between).

## Accessing the Feature
1. Log into the admin panel
2. In the navigation menu, go to **Employees**
3. Click on **Multiple Shifts** (this is separate from the existing "Employee Shifts" option)

## Setting Up Multiple Shifts

### Step 1: Select an Employee
- From the dropdown menu, select the employee you want to set shifts for
- The interface will load any existing shifts for that employee

### Step 2: Configure Shifts for Each Day
For each day of the week, you can set one or more shift periods:

1. **Adding a Shift Block**
   - Each day starts with one shift block by default
   - Click the **"Add Shift"** button to add additional shift blocks for that day
   - Set the **Start Time** and **End Time** for each shift block

2. **Removing a Shift Block**
   - If you have multiple shift blocks for a day, you can remove any of them using the **"Remove"** button
   - Note: You must keep at least one shift block per day

3. **Example Scenario**
   If an employee works from 9:00 AM to 12:00 PM and then again from 1:00 PM to 5:00 PM on Mondays:
   - Add a second shift block for Monday
   - Set the first shift block: Start Time = 09:00, End Time = 12:00
   - Set the second shift block: Start Time = 13:00, End Time = 17:00

### Step 3: Save Changes
- After configuring all shifts, click the **"Save Shifts"** button at the bottom
- You'll receive a confirmation message when the changes are saved successfully

## Working with Existing Shifts
- The system will automatically load any existing shifts for the selected employee
- You can modify existing shifts by changing their times
- Removing a shift block will delete that specific shift period from the database

## Important Notes
- This feature works alongside the existing "Employee Shifts" system
- Both systems use the same underlying database structure
- An employee can have either single shifts (using the traditional system) or multiple shifts (using this system), but not both simultaneously
- All times should be in 24-hour format (HH:MM)
- The system prevents overlapping shifts for the same employee on the same day