<?php
include 'koneksi.php';

// Ambil data tugas dari database 
$query = "SELECT diary_id, title, content, mood, created_at FROM diary ORDER BY created_at DESC"; 
$result = $koneksi->query($query); 
$diary_entries = []; 
if ($result->num_rows > 0) { 
  while ($row = $result->fetch_assoc()) { 
    $diary_entries[] = $row; 
  } 
}

// Tampilkan pesan status jika ada
if (isset($_GET['status']) && isset($_GET['message'])) {
    echo '<div class="alert alert-' . htmlspecialchars($_GET['status']) . '">';
    echo htmlspecialchars($_GET['message']);
    echo '</div>';
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mindful Journey - Diary</title>
    <link rel="stylesheet" href="css/diary.css" />
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
        <div class="diary-container">
          <div class="diary-header">
            <h1 class="page-title">My Diary</h1>
            <button class="new-entry-btn" onclick="showNewEntryForm()">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" fill="currentColor" />
              </svg>
              New Entry
            </button>
          </div>

          <!-- Form untuk entry baru -->
          <div class="entry-form" id="entryForm" style="display: none">
            <form action="save_diary.php" method="POST" id="diaryForm">
              <input type="hidden" name="form_type" value="new">
              <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control" required>
              </div>
              <div class="form-group">
                <label>How are you feeling today?</label>
                <div class="mood-selector">
                  <button type="button" class="mood-btn" onclick="selectMood('😊')">😊 Happy</button>
                  <button type="button" class="mood-btn" onclick="selectMood('🤔')">🤔 Thoughtful</button>
                  <button type="button" class="mood-btn" onclick="selectMood('😌')">😌 Peaceful</button>
                  <button type="button" class="mood-btn" onclick="selectMood('😔')">😔 Sad</button>
                  <button type="button" class="mood-btn" onclick="selectMood('😤')">😤 Frustrated</button>
                </div>
              </div>
              <div class="form-group">
                <label>Write your thoughts</label>
                <textarea name="content" class="entry-textarea" placeholder="What's on your mind today?" required></textarea>
              </div>
              <input type="hidden" name="mood" id="selectedMood">
              <div class="form-buttons">
                <button type="button" class="cancel-btn" onclick="hideNewEntryForm()">Cancel</button>
                <button type="submit" class="save-btn">Save Entry</button>
              </div>
            </form>
          </div>

          <div class="diary-entries">
            <?php foreach($diary_entries as $entry): ?>
              <div class="diary-entry" data-diary-id="<?php echo $entry['diary_id']; ?>">
                <div class="entry-header">
                  <div class="entry-title"><?php echo htmlspecialchars($entry['title']); ?></div>
                  <div class="entry-date"><?php echo date('F d, Y', strtotime($entry['created_at'])); ?></div>
                  <div class="entry-mood">
                    <span class="mood-icon"><?php echo htmlspecialchars($entry['mood']); ?></span>
                  </div>
                </div>
                <div class="entry-content"><?php echo htmlspecialchars($entry['content']); ?></div>
                <div class="entry-footer">
                  <button class="entry-button edit-button" onclick="editEntry(<?php echo $entry['diary_id']; ?>)">Edit</button>
                  <button class="entry-button delete-button" onclick="deleteEntry(<?php echo $entry['diary_id']; ?>)">Delete</button>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
    <script>
      document.getElementById('diaryForm').addEventListener('submit', function(e) {
        const mood = document.getElementById('selectedMood').value;
        if (!mood) {
          e.preventDefault();
          alert('Please select your mood');
          return false;
        }
      });

      function showNewEntryForm() {
        document.getElementById('entryForm').style.display = 'block';
        document.querySelector('#entryForm form').reset();
        document.querySelector('#entryForm form').action = 'save_diary.php';
        const hiddenInput = document.querySelector('input[name="diary_id"]');
        if (hiddenInput) {
          hiddenInput.remove();
        }
        document.querySelectorAll('.mood-btn').forEach((btn) => {
          btn.classList.remove('selected');
        });
        document.getElementById('selectedMood').value = '';
      }

      function hideNewEntryForm() {
        document.getElementById('entryForm').style.display = 'none';
        document.querySelector('#entryForm form').reset();
      }

      function selectMood(mood) {
        document.querySelectorAll('.mood-btn').forEach((btn) => {
          btn.classList.remove('selected');
        });
        event.target.classList.add('selected');
        document.getElementById('selectedMood').value = mood;
        document.getElementById('selectedMood').setAttribute('required', 'required');
      }

      function editEntry(id) {
        document.querySelector('#entryForm form').reset();
        console.log('Editing diary entry:', id);
        
        fetch('get_diary.php?id=' + id)
          .then(response => response.json())
          .then(data => {
            console.log('Received data:', data);
            document.getElementById('entryForm').style.display = 'block';
            document.querySelector('input[name="title"]').value = data.title;
            document.querySelector('textarea[name="content"]').value = data.content;
            document.querySelector('#entryForm form').action = 'update_diary.php';
            
            const existingInput = document.querySelector('input[name="diary_id"]');
            if (existingInput) {
              existingInput.remove();
            }
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'diary_id';
            hiddenInput.value = id;
            document.querySelector('#entryForm form').appendChild(hiddenInput);
            
            setTimeout(() => {
              selectMood(data.mood);
              console.log('Mood set to:', data.mood);
            }, 100);
          })
          .catch(error => {
            console.error('Error:', error);
            alert('Gagal mengambil data diary');
          });
      }

      function deleteEntry(id) {
        fetch('delete_diary.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: 'diary_id=' + id
        })
        .then(response => response.text())
        .then(() => {
          // Hapus entry dari tampilan
          const entryElement = document.querySelector(`[data-diary-id="${id}"]`);
          if (entryElement) {
            entryElement.remove();
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Gagal menghapus entry');
        });
      }
    </script>
  </body>
</html>
