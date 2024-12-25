<?php
include 'koneksi.php';

// Ambil data tugas dari database 
$today = date('Y-m-d');
$query = "SELECT task_id, task_name, tag, due_date, is_completed FROM todo 
          ORDER BY CASE 
              WHEN due_date = '$today' THEN 1 
              WHEN due_date > '$today' THEN 2
              ELSE 3 
          END, 
          due_date ASC";
$result = $koneksi->query($query);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mindful Journey - Todo</title>
    <link rel="stylesheet" href="css/todo.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  </head>
  <body>
    <div class="container">
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
        <div class="todo-container">
          <h1 class="page-title">Todo List</h1>

          <div class="tag-selection">
            <div class="left-section">
              <span class="tag-label">Tags:</span>
              <div class="tag-buttons">
                <button class="tag-button active" data-tag="all">All</button>
                <button class="tag-button" data-tag="tugas">Tugas</button>
                <button class="tag-button" data-tag="personal">Personal</button>
                <button class="tag-button" data-tag="health">Health</button>
              </div>
            </div>
            <div class="add-todo">
              <button class="add-button">Add Task</button>
            </div>
          </div>

          <!-- Tambahkan tab untuk Today dan Upcoming -->
          <div class="todo-tabs">
            <button class="tab-button active" data-tab="today">Today</button>
            <button class="tab-button" data-tab="upcoming">Upcoming</button>
          </div>

          <!-- Today's Tasks -->
          <div class="todo-section" id="today-tasks">
            <h2 class="section-title">Today's Tasks</h2>
            <div class="todo-list">
              <?php 
              $today = date('Y-m-d');
              if($result->num_rows > 0):
                $result->data_seek(0); // Reset pointer
                while($task = $result->fetch_assoc()):
                  if($task['due_date'] == $today):
              ?>
                <div class="todo-item" data-task-id="<?= $task['task_id'] ?>" data-tag="<?= $task['tag'] ?>">
                  <div class="todo-checkbox">
                    <input type="checkbox" <?= $task['is_completed'] ? 'checked' : '' ?> />
                    <span class="checkmark"></span>
                  </div>
                  <div class="todo-content">
                    <div class="todo-text <?= $task['is_completed'] ? 'checked' : '' ?>">
                      <?= htmlspecialchars($task['task_name']) ?>
                    </div>
                    <?php if(!empty($task['due_date'])): ?>
                      <div class="todo-details">
                        <span class="deadline">Due: <?= htmlspecialchars($task['due_date']) ?></span>
                      </div>
                    <?php endif; ?>
                  </div>
                  <div class="todo-actions">
                    <button class="todo-button edit-button">Edit</button>
                    <button class="todo-button delete-button">Delete</button>
                  </div>
                </div>
              <?php 
                      endif;
                    endwhile;
                  endif;
                  ?>
            </div>
          </div>

          <!-- Upcoming Tasks -->
          <div class="todo-section" id="upcoming-tasks" style="display: none;">
            <h2 class="section-title">Upcoming Tasks</h2>
            <div class="todo-list">
              <?php 
              if($result->num_rows > 0):
                $result->data_seek(0); // Reset pointer
                while($task = $result->fetch_assoc()):
                  if($task['due_date'] > $today):
              ?>
                <div class="todo-item" data-task-id="<?= $task['task_id'] ?>" data-tag="<?= $task['tag'] ?>">
                  <div class="todo-checkbox">
                    <input type="checkbox" <?= $task['is_completed'] ? 'checked' : '' ?> />
                    <span class="checkmark"></span>
                  </div>
                  <div class="todo-content">
                    <div class="todo-text <?= $task['is_completed'] ? 'checked' : '' ?>">
                      <?= htmlspecialchars($task['task_name']) ?>
                    </div>
                    <?php if(!empty($task['due_date'])): ?>
                      <div class="todo-details">
                        <span class="deadline">Due: <?= htmlspecialchars($task['due_date']) ?></span>
                      </div>
                    <?php endif; ?>
                  </div>
                  <div class="todo-actions">
                    <button class="todo-button edit-button">Edit</button>
                    <button class="todo-button delete-button">Delete</button>
                  </div>
                </div>
              <?php 
                      endif;
                    endwhile;
                  endif;
                  ?>
            </div>
          </div>
        </div>
      </div>

      <div class="modal" id="addTaskModal">
        <div class="modal-content">
          <h2>Add New Task</h2>
          <form id="addTaskForm">
            <div class="form-group">
              <label for="taskName">Task Name:</label>
              <input type="text" id="taskName" required>
            </div>

            <div class="form-group">
              <label>Select Tag:</label>
              <div class="modal-tag-buttons">
                <button type="button" class="tag-button" data-tag="tugas">Tugas</button>
                <button type="button" class="tag-button" data-tag="personal">Personal</button>
                <button type="button" class="tag-button" data-tag="health">Health</button>
              </div>
            </div>

            <div class="form-group tugas-options" style="display: none;">
              <div class="sub-group">
                <label>Deadline:</label>
                <input type="date" id="deadline" required>
              </div>
            </div>

            <div class="modal-actions">
              <button type="button" class="cancel-button" onclick="closeModal()">Cancel</button>
              <button type="submit" class="submit-button">Save</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Tambahkan modal update setelah modal add -->
      <div class="modal" id="updateTaskModal">
          <div class="modal-content">
              <h2>Update Task</h2>
              <form id="updateTaskForm">
                  <input type="hidden" id="updateTaskId">
                  <div class="form-group">
                      <label for="updateTaskName">Task Name:</label>
                      <input type="text" id="updateTaskName" required>
                  </div>

                  <div class="form-group">
                      <label>Select Tag:</label>
                      <div class="modal-tag-buttons">
                          <button type="button" class="tag-button" data-tag="tugas">Tugas</button>
                          <button type="button" class="tag-button" data-tag="personal">Personal</button>
                          <button type="button" class="tag-button" data-tag="health">Health</button>
                      </div>
                  </div>

                  <div class="form-group update-tugas-options" style="display: none;">
                      <div class="sub-group">
                          <label>Deadline:</label>
                          <input type="date" id="updateDeadline" required>
                      </div>
                  </div>

                  <div class="modal-actions">
                      <button type="button" class="cancel-button" onclick="closeUpdateModal()">Cancel</button>
                      <button type="submit" class="submit-button">Update</button>
                  </div>
              </form>
          </div>
      </div>

      <!-- Update modal delete -->
      <div class="modal" id="deleteTaskModal">
          <div class="modal-content delete-modal">
              <div class="delete-icon">
                  <i class="fas fa-exclamation-circle"></i>
              </div>
              <h2>Delete Task</h2>
              <p class="delete-message">Are you sure you want to delete this task?</p>
              <p class="task-to-delete"></p>
              <input type="hidden" id="deleteTaskId">
              <div class="modal-actions delete-actions">
                  <button type="button" class="cancel-button" onclick="closeDeleteModal()">
                      <i class="fas fa-times"></i> Cancel
                  </button>
                  <button type="button" class="delete-button" onclick="confirmDelete()">
                      <i class="fas fa-trash-alt"></i> Delete
                  </button>
              </div>
          </div>
      </div>
    </div>
    <script>
      // Di awal script
      console.log('Script loaded');

      // Get all checkboxes
      const checkboxes = document.querySelectorAll('.todo-checkbox input[type="checkbox"]');
      const tagButtons = document.querySelectorAll('.tag-button');
      let selectedTags = new Set();

      // Tag button click handler
      tagButtons.forEach(button => {
        button.addEventListener('click', function() {
          this.classList.toggle('selected');
          const tag = this.getAttribute('data-tag');
          
          if (selectedTags.has(tag)) {
            selectedTags.delete(tag);
          } else {
            selectedTags.add(tag);
          }
        });
      });

      // Update checkbox event listener
      checkboxes.forEach((checkbox) => {
        checkbox.addEventListener('change', function() {
          const todoItem = this.closest('.todo-item');
          const taskId = todoItem.dataset.taskId;
          const todoText = this.parentElement.nextElementSibling.querySelector('.todo-text');
          
          const formData = new FormData();
          formData.append('task_id', taskId);
          formData.append('is_completed', this.checked ? 1 : 0);

          fetch('update_task_status.php', {
            method: 'POST',
            body: formData
          })
          .then(response => response.json())
          .then(data => {
            if (data.status === 'success') {
              todoText.classList.toggle('checked', this.checked);
            } else {
              alert('Failed to update task status');
              this.checked = !this.checked;
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('Failed to update task status');
            this.checked = !this.checked;
          });
        });
      });

      // Modal functionality
      const modal = document.getElementById('addTaskModal');
      const addButton = document.querySelector('.add-button');
      const taskForm = document.getElementById('addTaskForm');
      const workOptions = document.querySelector('.work-options');
      const modalTagButtons = document.querySelectorAll('.modal-tag-buttons .tag-button');
      
      let selectedModalTag = null;

      // Show modal when clicking Add Task button
      addButton.addEventListener('click', () => {
        console.log('Add button clicked');
        console.log('Modal display before:', modal.style.display);
        modal.style.display = 'block';
        console.log('Modal display after:', modal.style.display);
      });

      // Close modal function
      function closeModal() {
        console.log('Closing modal');
        modal.style.display = 'none';
        taskForm.reset();
        workOptions.style.display = 'none';
        modalTagButtons.forEach(btn => btn.classList.remove('selected'));
        selectedModalTag = null;
      }

      // Close modal when clicking outside
      window.addEventListener('click', (e) => {
        console.log('Click event:', e.target);
        if (e.target === modal) {
          closeModal();
        }
      });

      // Handle tag selection in modal
      modalTagButtons.forEach(button => {
        button.addEventListener('click', function() {
          modalTagButtons.forEach(btn => btn.classList.remove('selected'));
          this.classList.add('selected');
          selectedModalTag = this.getAttribute('data-tag');
          
          const tugasOptions = document.querySelector('.tugas-options');
          
          // Show/hide tugas options based on selected tag
          if (selectedModalTag === 'tugas') {
            tugasOptions.style.display = 'block';
            document.getElementById('deadline').required = true;
          } else {
            tugasOptions.style.display = 'none';
            document.getElementById('deadline').required = false;
          }
        });
      });

      // Handle form submission
      taskForm.addEventListener('submit', function(e) {
        e.preventDefault();
        AddModal();
      });

      document.addEventListener('DOMContentLoaded', function() {
        console.log('Modal element:', modal);
        console.log('Add button element:', addButton);
        
        if (!modal || !addButton) {
          console.error('Modal or Add button not found!');
        }
      });

      // Tambahkan fungsi AddModal yang baru
      function AddModal() {
        console.log('AddModal called'); // Debug log

        if (!selectedModalTag) {
            alert('Please select a tag');
            return;
        }

        const taskName = document.getElementById('taskName').value;
        if (!taskName) {
            alert('Please enter task name');
            return;
        }

        console.log('Preparing form data'); // Debug log

        // Buat FormData object
        const formData = new FormData();
        formData.append('task_name', taskName);
        formData.append('tag', selectedModalTag);

        if (selectedModalTag === 'tugas') {
            const deadline = document.getElementById('deadline').value;
            if (!deadline) {
                alert('Please select deadline');
                return;
            }
            formData.append('due_date', deadline);
        }

        console.log('Sending data to server'); // Debug log

        // Kirim data ke server
        fetch('save_task.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            console.log('Response received:', response); // Debug log
            return response.json();
        })
        .then(data => {
            console.log('Data received:', data); // Debug log
            if (data.status === 'success') {
                // Refresh halaman untuk menampilkan perubahan
                location.reload();
            } else {
                alert('Failed to add task: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to add task. Please try again.');
        });
      }

      // Modal update functionality
      const updateModal = document.getElementById('updateTaskModal');
      const updateForm = document.getElementById('updateTaskForm');
      const updateTugasOptions = document.querySelector('.update-tugas-options');
      const updateModalTagButtons = document.querySelectorAll('#updateTaskModal .modal-tag-buttons .tag-button');
      let selectedUpdateModalTag = null;

      // Edit button click handler
      document.querySelectorAll('.edit-button').forEach(button => {
          button.addEventListener('click', function() {
              const todoItem = this.closest('.todo-item');
              const taskId = todoItem.dataset.taskId;
              const taskName = todoItem.querySelector('.todo-text').textContent.trim();
              const tag = todoItem.querySelector('.tag') ? todoItem.querySelector('.tag').getAttribute('data-tag') : '';
              const deadline = todoItem.querySelector('.deadline') ? 
                  todoItem.querySelector('.deadline').textContent.replace('Due: ', '').trim() : '';

              // Set values in update modal
              document.getElementById('updateTaskId').value = taskId;
              document.getElementById('updateTaskName').value = taskName;
              
              // Select the correct tag button
              updateModalTagButtons.forEach(btn => {
                  if (btn.getAttribute('data-tag') === tag) {
                      btn.classList.add('selected');
                      selectedUpdateModalTag = tag;
                      if (tag === 'tugas') {
                          updateTugasOptions.style.display = 'block';
                          document.getElementById('updateDeadline').value = deadline;
                      }
                  } else {
                      btn.classList.remove('selected');
                  }
              });

              updateModal.style.display = 'block';
          });
      });

      // Close update modal function
      function closeUpdateModal() {
          updateModal.style.display = 'none';
          updateForm.reset();
          updateTugasOptions.style.display = 'none';
          updateModalTagButtons.forEach(btn => btn.classList.remove('selected'));
          selectedUpdateModalTag = null;
      }

      // Handle tag selection in update modal
      updateModalTagButtons.forEach(button => {
          button.addEventListener('click', function() {
              updateModalTagButtons.forEach(btn => btn.classList.remove('selected'));
              this.classList.add('selected');
              selectedUpdateModalTag = this.getAttribute('data-tag');
              
              if (selectedUpdateModalTag === 'tugas') {
                  updateTugasOptions.style.display = 'block';
                  document.getElementById('updateDeadline').required = true;
              } else {
                  updateTugasOptions.style.display = 'none';
                  document.getElementById('updateDeadline').required = false;
              }
          });
      });

      // Handle update form submission
      updateForm.addEventListener('submit', function(e) {
          e.preventDefault();
          
          if (!selectedUpdateModalTag) {
              alert('Please select a tag');
              return;
          }

          const taskId = document.getElementById('updateTaskId').value;
          const taskName = document.getElementById('updateTaskName').value;

          if (!taskName) {
              alert('Please enter task name');
              return;
          }

          // Buat FormData object
          const formData = new FormData();
          formData.append('task_id', taskId);
          formData.append('task_name', taskName);
          formData.append('tag', selectedUpdateModalTag);

          if (selectedUpdateModalTag === 'tugas') {
              const deadline = document.getElementById('updateDeadline').value;
              if (!deadline) {
                  alert('Please select deadline');
                  return;
              }
              formData.append('due_date', deadline);
          }

          // Kirim data ke server
          fetch('update_task.php', {
              method: 'POST',
              body: formData
          })
          .then(response => response.json())
          .then(data => {
              if (data.status === 'success') {
                  location.reload();
              } else {
                  alert('Failed to update task: ' + data.message);
              }
          })
          .catch(error => {
              console.error('Error:', error);
              alert('Failed to update task. Please try again.');
          });
      });

      // Modal delete functionality
      const deleteModal = document.getElementById('deleteTaskModal');
      let taskToDelete = null;

      // Delete button click handler
      document.querySelectorAll('.delete-button').forEach(button => {
          button.addEventListener('click', function(e) {
              e.preventDefault(); // Mencegah event default
              e.stopPropagation(); // Mencegah event bubbling
              
              const todoItem = this.closest('.todo-item');
              const taskId = todoItem.dataset.taskId;
              const taskName = todoItem.querySelector('.todo-text').textContent.trim();
              
              taskToDelete = todoItem;
              document.getElementById('deleteTaskId').value = taskId;
              document.querySelector('.task-to-delete').textContent = `"${taskName}"`;
              deleteModal.style.display = 'block';
          });
      });

      // Close delete modal function
      function closeDeleteModal() {
          deleteModal.style.display = 'none';
          taskToDelete = null;
      }

      // Confirm delete function
      function confirmDelete() {
          const taskId = document.getElementById('deleteTaskId').value;
          
          // Tambahkan debug log
          console.log('Deleting task with ID:', taskId);
          
          const formData = new FormData();
          formData.append('task_id', taskId);

          fetch('delete_task.php', {
              method: 'POST',
              body: formData
          })
          .then(response => {
              if (!response.ok) {
                  throw new Error('Network response was not ok');
              }
              return response.json();
          })
          .then(data => {
              console.log('Response data:', data); // Debug log
              if (data.status === 'success') {
                  if (taskToDelete) {
                      taskToDelete.remove();
                  }
                  closeDeleteModal();
              } else {
                  throw new Error(data.message || 'Failed to delete task');
              }
          })
          .catch(error => {
              console.error('Error:', error);
              alert('Failed to delete task. Please try again.');
          });
      }

      // Close delete modal when clicking outside
      window.addEventListener('click', (e) => {
          if (e.target === deleteModal) {
              closeDeleteModal();
          }
      });

      // Tab functionality
      const tabButtons = document.querySelectorAll('.tab-button');
      const todoSections = document.querySelectorAll('.todo-section');

      tabButtons.forEach(button => {
          button.addEventListener('click', () => {
              // Remove active class from all buttons
              tabButtons.forEach(btn => btn.classList.remove('active'));
              // Add active class to clicked button
              button.classList.add('active');
              
              // Hide all sections
              todoSections.forEach(section => section.style.display = 'none');
              // Show selected section
              const targetSection = button.dataset.tab;
              document.getElementById(`${targetSection}-tasks`).style.display = 'block';
          });
      });

      // Tag filtering functionality
      const tagFilterButtons = document.querySelectorAll('.tag-selection .tag-button');
      const todoItems = document.querySelectorAll('.todo-item');

      tagFilterButtons.forEach(button => {
          button.addEventListener('click', () => {
              // Remove active class from all buttons
              tagFilterButtons.forEach(btn => btn.classList.remove('active'));
              // Add active class to clicked button
              button.classList.add('active');
              
              const selectedTag = button.getAttribute('data-tag');
              
              // Show/hide todo items based on selected tag
              todoItems.forEach(item => {
                  if (selectedTag === 'all') {
                      item.style.display = 'flex';
                  } else {
                      const itemTag = item.getAttribute('data-tag');
                      item.style.display = itemTag === selectedTag ? 'flex' : 'none';
                  }
              });
          });
      });
    </script>
  </body>
</html>
