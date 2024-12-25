<?php
session_start();
// Update koneksi database
$koneksi = mysqli_connect("localhost", "root", "", "mindfuljourney");

// Check connection
if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch habits from database
$currentWeek = isset($_GET['week']) ? $_GET['week'] : 1;
$currentMonth = isset($_GET['month']) ? $_GET['month'] : "December";
$currentYear = isset($_GET['year']) ? $_GET['year'] : date('Y');

$query = "SELECT * FROM habits WHERE week = $currentWeek AND month = '$currentMonth' AND year = $currentYear";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mindful Journey - Daily Habits</title>
    <link rel="stylesheet" href="dailyhabits.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>
<body>
    <div class="container">
        <!-- Sidebar remains the same -->
        <div class="sidebar">
            <div class="logo">Mindful Journey</div>

            <div class="section">
                <div class="section-title">NOTES</div>
                <a href="kalender.php" class="menu-item">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M19 4H18V2H16V4H8V2H6V4H5C3.89 4 3.01 4.9 3.01 6L3 20C3 21.1 3.89 22 5 22H19C20.1 22 21 21.1 21 20V6C21 4.9 20.1 4 19 4ZM19 20H5V9H19V20Z" fill="currentColor" />
                    </svg>
                    <span>Calendar</span>
                </a>
            </div>

            <div class="section">
                <div class="section-title">MINDFUL TASK</div>
                <a href="todo.php" class="menu-item">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M19 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.9 20.1 3 19 3ZM19 19H5V5H19V19Z" fill="currentColor" />
                    </svg>
                    <span>To Do</span>
                </a>
                <a href="dailyhabits.php" class="menu-item">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M3 13H5V11H3V13ZM3 17H5V15H3V17ZM3 9H5V7H3V9ZM7 13H21V11H7V13ZM7 17H21V15H7V17ZM7 7V9H21V7H7Z" fill="currentColor" />
                    </svg>
                    <span>Daily Habits</span>
                </a>
                <a href="diary.php" class="menu-item">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M16 11C17.66 11 18.99 9.66 18.99 8C18.99 6.34 17.66 5 16 5C14.34 5 13 6.34 13 8C13 9.66 14.34 11 16 11ZM8 11C9.66 11 10.99 9.66 10.99 8C10.99 6.34 9.66 5 8 5C6.34 5 5 6.34 5 8C5 9.66 6.34 11 8 11ZM8 13C5.67 13 1 14.17 1 16.5V19H15V16.5C15 14.17 10.33 13 8 13ZM16 13C15.71 13 15.38 13.02 15.03 13.05C16.19 13.89 17 15.02 17 16.5V19H23V16.5C23 14.17 18.33 13 16 13Z" fill="currentColor" />
                    </svg>
                    <span>Diary</span>
                </a>
            </div>

            <div class="section">
                <div class="section-title">BILLINGS</div>
                <a href="billing.html" class="menu-item">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M20 4H4C2.89 4 2.01 4.89 2.01 6L2 18C2 19.11 2.89 20 4 20H20C21.11 20 22 19.11 22 18V6C22 4.89 21.11 4 20 4ZM20 18H4V12H20V18ZM20 8H4V6H20V8Z" fill="currentColor" />
                    </svg>
                    <span>Billing & Invoices</span>
                </a>
                <a href="upgrade.html" class="menu-item">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M12 1L3 5V11C3 16.55 6.84 21.74 12 23C17.16 21.74 21 16.55 21 11V5L12 1ZM12 11.99H19C18.47 16.11 15.72 19.78 12 20.93V12H5V6.3L12 3.19V11.99Z" fill="currentColor" />
                    </svg>
                    <span>Upgrade</span>
                </a>
            </div>
        </div>

        <div class="main-content">
            <div class="daily-container">
                <h1 class="page-title">Daily Habits</h1>

                <div class="date-filter">
                    <div class="filter-group">
                        <label>Minggu:</label>
                        <select class="filter-select" name="week">
                            <?php
                            $currentWeek = isset($_GET['week']) ? $_GET['week'] : 1;
                            for ($i = 1; $i <= 4; $i++) {
                                $selected = ($i == $currentWeek) ? 'selected' : '';
                                echo "<option value='$i' $selected>Minggu ke-$i</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label>Bulan:</label>
                        <select class="filter-select" name="month">
                            <?php
                            $months = array("January", "February", "March", "April", "May", "June", 
                                          "July", "August", "September", "October", "November", "December");
                            $currentMonth = isset($_GET['month']) ? $_GET['month'] : "December";
                            foreach ($months as $month) {
                                $selected = ($month == $currentMonth) ? "selected" : "";
                                echo "<option value='$month' $selected>$month</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label>Tahun:</label>
                        <select class="filter-select" name="year">
                            <?php
                            $currentYear = isset($_GET['year']) ? $_GET['year'] : date('Y');
                            for ($year = $currentYear - 1; $year <= $currentYear + 1; $year++) {
                                $selected = ($year == $currentYear) ? "selected" : "";
                                echo "<option value='$year' $selected>$year</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="habits-table">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Habits</th>
                                <th>1</th>
                                <th>2</th>
                                <th>3</th>
                                <th>4</th>
                                <th>5</th>
                                <th>6</th>
                                <th>7</th>
                                <th>Completed</th>
                                <th>Progress</th>
                                <th>Goal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                $counter = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $completed = $row['completed'];
                                    $goal = $row['goal'];
                                    $progress = ($completed / $goal) * 100;
                                    ?>
                                    <tr>
                                        <td><?php echo $counter; ?></td>
                                        <td><?php echo htmlspecialchars($row['habit_name']); ?></td>
                                        <?php
                                        // Generate checkboxes for 7 days
                                        for ($i = 1; $i <= 7; $i++) {
                                            $checked = ($row["day$i"] == 1) ? "completed" : "";
                                            echo "<td><div class='checkbox $checked' data-day='$i' data-habit-id='{$row['id']}'></div></td>";
                                        }
                                        ?>
                                        <td><?php echo $completed; ?></td>
                                        <td>
                                            <div class="progress-bar">
                                                <div class="progress" style="width: <?php echo $progress; ?>%"></div>
                                            </div>
                                        </td>
                                        <td><?php echo $goal; ?></td>
                                    </tr>
                                    <?php
                                    $counter++;
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="12" style="text-align: center; padding: 20px;">
                                        No habits data for this week
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="action-buttons">
                    <button class="action-btn add">Add Habit</button>
                    <button class="action-btn delete">Delete Habit</button>
                    <button class="action-btn update">Update Habit</button>
                </div>

                <!-- Modal Form -->
                <div id="habitModal" class="modal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2>Create New Habit</h2>
                            <span class="close">&times;</span>
                        </div>
                        <div class="modal-body">
                            <form id="habitForm">
                                <div class="form-group">
                                    <label for="habitName"><span class="required">*</span> Habit Name</label>
                                    <input type="text" id="habitName" name="habit_name" placeholder="Eg. Exercise" required>
                                </div>
                                <div class="form-group">
                                    <label for="habitGoal"><span class="required">*</span> Goal (max 7 days)</label>
                                    <input type="number" id="habitGoal" name="goal" 
                                           placeholder="Number of times to perform habit in a week" 
                                           min="1" max="7" required>
                                    <span class="error-message" id="goalError"></span>
                                </div>
                                <div class="form-buttons">
                                    <button type="submit" class="save-btn">Save</button>
                                    <button type="button" class="cancel-btn">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tambahkan setelah modal Add Habit yang sudah ada -->
                <div id="editModal" class="modal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2>Edit Habit</h2>
                            <span class="close-edit">&times;</span>
                        </div>
                        <div class="modal-body">
                            <form id="editForm">
                                <input type="hidden" id="editHabitId">
                                <div class="form-group">
                                    <label for="editHabitName"><span class="required">*</span> Habit Name</label>
                                    <input type="text" id="editHabitName" name="habit_name" placeholder="Eg. Exercise" required>
                                </div>
                                <div class="form-group">
                                    <label for="editHabitGoal"><span class="required">*</span> Goal (max 7 days)</label>
                                    <input type="number" id="editHabitGoal" name="goal" 
                                           placeholder="Number of times to perform habit in a week" 
                                           min="1" max="7" required>
                                    <span class="error-message" id="editGoalError"></span>
                                </div>
                                <div class="form-buttons">
                                    <button type="submit" class="save-btn">Save Changes</button>
                                    <button type="button" class="cancel-btn">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Handle checkbox clicks with AJAX
            $('.checkbox').click(function() {
                const habitId = $(this).data('habit-id');
                const day = $(this).data('day');
                const isCompleted = $(this).hasClass('completed') ? 0 : 1;

                $.ajax({
                    url: 'update_habit.php',
                    method: 'POST',
                    data: {
                        habit_id: habitId,
                        day: day,
                        completed: isCompleted
                    },
                    success: function(response) {
                        // Update UI based on response
                        location.reload();
                    }
                });
            });

            // Modal functionality
            const modal = document.getElementById("habitModal");
            const addBtn = document.querySelector(".action-btn.add");
            const closeBtn = document.querySelector(".close");
            const cancelBtn = document.querySelector(".cancel-btn");
            const habitForm = document.getElementById("habitForm");

            // Open modal
            addBtn.onclick = function() {
                modal.style.display = "block";
            }

            // Close modal
            closeBtn.onclick = function() {
                modal.style.display = "none";
            }

            cancelBtn.onclick = function() {
                modal.style.display = "none";
            }

            // Close modal when clicking outside
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }

            // Handle form submission
            habitForm.onsubmit = function(e) {
                e.preventDefault();
                
                const habitName = document.getElementById("habitName").value.trim();
                const habitGoal = parseInt(document.getElementById("habitGoal").value);
                const selectedWeek = $('select[name="week"]').val();
                const selectedMonth = $('select[name="month"]').val();
                const selectedYear = $('select[name="year"]').val();
                const goalError = document.getElementById("goalError");

                // Reset error message
                goalError.textContent = "";

                // Validate input
                if(!habitName) {
                    alert("Please enter a valid habit name");
                    return;
                }

                // Validate goal
                if(habitGoal <= 0 || habitGoal > 7) {
                    goalError.textContent = "Goal must be between 1 and 7 days";
                    return;
                }

                $.ajax({
                    url: 'add_habit.php',
                    method: 'POST',
                    data: {
                        habit_name: habitName,
                        goal: habitGoal,
                        week: selectedWeek,
                        month: selectedMonth,
                        year: selectedYear
                    },
                    success: function(response) {
                        if(response.includes("Success")) {
                            modal.style.display = "none";
                            habitForm.reset();
                            location.reload();
                        } else {
                            alert("Error adding habit: " + response);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("Error connecting to server: " + error);
                    }
                });
            }

            // Add input validation for goal field
            document.getElementById("habitGoal").addEventListener("input", function(e) {
                const value = parseInt(this.value);
                const goalError = document.getElementById("goalError");
                
                if(value > 7) {
                    this.value = 7;
                    goalError.textContent = "Maximum goal is 7 days";
                } else if(value < 0) {
                    this.value = 1;
                    goalError.textContent = "Minimum goal is 1 day";
                } else {
                    goalError.textContent = "";
                }
            });

            // Delete habit
            $('.action-btn.delete').click(function() {
                const selectedRow = $('tr.selected');
                if (selectedRow.length) {
                    const habitId = selectedRow.find('.checkbox').first().data('habit-id');
                    if (confirm('Are you sure you want to delete this habit?')) {
                        $.ajax({
                            url: 'delete_habit.php',
                            method: 'POST',
                            data: { habit_id: habitId },
                            success: function(response) {
                                location.reload();
                            }
                        });
                    }
                } else {
                    alert('Please select a habit to delete');
                }
            });

            // Select habit
            $('tbody tr').click(function() {
                $('tr').removeClass('selected');
                $(this).addClass('selected');
            });

            // Handle week change
            $('select[name="week"]').change(function() {
                const selectedWeek = $(this).val();
                const selectedMonth = $('select[name="month"]').val();
                const selectedYear = $('select[name="year"]').val();
                window.location.href = `dailyhabits.php?week=${selectedWeek}&month=${selectedMonth}&year=${selectedYear}`;
            });

            // Handle month change
            $('select[name="month"]').change(function() {
                const selectedWeek = $('select[name="week"]').val();
                const selectedMonth = $(this).val();
                const selectedYear = $('select[name="year"]').val();
                window.location.href = `dailyhabits.php?week=${selectedWeek}&month=${selectedMonth}&year=${selectedYear}`;
            });

            // Handle year change
            $('select[name="year"]').change(function() {
                const selectedWeek = $('select[name="week"]').val();
                const selectedMonth = $('select[name="month"]').val();
                const selectedYear = $(this).val();
                window.location.href = `dailyhabits.php?week=${selectedWeek}&month=${selectedMonth}&year=${selectedYear}`;
            });

            // Edit habit functionality
            const editModal = document.getElementById("editModal");
            const editBtn = document.querySelector(".action-btn.update");
            const closeEditBtn = document.querySelector(".close-edit");
            const editForm = document.getElementById("editForm");

            // Open edit modal
            editBtn.onclick = function() {
                const selectedRow = $('tr.selected');
                if (selectedRow.length) {
                    const habitId = selectedRow.find('.checkbox').first().data('habit-id');
                    const habitName = selectedRow.find('td:nth-child(2)').text();
                    const habitGoal = selectedRow.find('td:last-child').text();

                    // Populate form with current values
                    document.getElementById("editHabitId").value = habitId;
                    document.getElementById("editHabitName").value = habitName;
                    document.getElementById("editHabitGoal").value = habitGoal;

                    editModal.style.display = "block";
                } else {
                    alert('Please select a habit to edit');
                }
            }

            // Close edit modal
            closeEditBtn.onclick = function() {
                editModal.style.display = "none";
            }

            // Close edit modal when clicking outside
            window.onclick = function(event) {
                if (event.target == editModal) {
                    editModal.style.display = "none";
                }
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }

            // Handle edit form submission
            editForm.onsubmit = function(e) {
                e.preventDefault();
                
                const habitId = document.getElementById("editHabitId").value;
                const habitName = document.getElementById("editHabitName").value.trim();
                const habitGoal = parseInt(document.getElementById("editHabitGoal").value);
                const editGoalError = document.getElementById("editGoalError");

                // Reset error message
                editGoalError.textContent = "";

                // Validate input
                if(!habitName) {
                    alert("Please enter a valid habit name");
                    return;
                }

                // Validate goal
                if(habitGoal <= 0 || habitGoal > 7) {
                    editGoalError.textContent = "Goal must be between 1 and 7 days";
                    return;
                }

                $.ajax({
                    url: 'edit_habit.php',
                    method: 'POST',
                    data: {
                        habit_id: habitId,
                        habit_name: habitName,
                        goal: habitGoal
                    },
                    success: function(response) {
                        if(response.includes("Success")) {
                            editModal.style.display = "none";
                            editForm.reset();
                            location.reload();
                        } else {
                            alert("Error updating habit: " + response);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("Error connecting to server: " + error);
                    }
                });
            }

            // Add input validation for edit goal field
            document.getElementById("editHabitGoal").addEventListener("input", function(e) {
                const value = parseInt(this.value);
                const editGoalError = document.getElementById("editGoalError");
                
                if(value > 7) {
                    this.value = 7;
                    editGoalError.textContent = "Maximum goal is 7 days";
                } else if(value < 0) {
                    this.value = 1;
                    editGoalError.textContent = "Minimum goal is 1 day";
                } else {
                    editGoalError.textContent = "";
                }
            });
        });
    </script>
</body>
</html> 