<?php
include 'koneksi.php';

// Fungsi untuk mendapatkan jumlah hari dalam bulan
function getDaysInMonth($month, $year) {
    return cal_days_in_month(CAL_GREGORIAN, $month, $year);
}

// Mendapatkan bulan dan tahun saat ini jika tidak ada parameter
$month = isset($_GET['month']) ? $_GET['month'] : date('n');
$year = isset($_GET['year']) ? $_GET['year'] : date('Y');

// Mendapatkan nama bulan
$monthName = date('F', mktime(0, 0, 0, $month, 1, $year));

// Mendapatkan hari pertama dari bulan
$firstDay = date('w', mktime(0, 0, 0, $month, 1, $year));

// Mendapatkan jumlah hari dalam bulan
$daysInMonth = getDaysInMonth($month, $year);

// Mendapatkan hari terakhir dari bulan sebelumnya
$prevMonth = $month - 1;
$prevYear = $year;
if ($prevMonth == 0) {
    $prevMonth = 12;
    $prevYear--;
}
$daysInPrevMonth = getDaysInMonth($prevMonth, $prevYear);

// Logika untuk bulan sebelumnya dan selanjutnya
$prevMonthLink = $month - 1;
$nextMonthLink = $month + 1;
$prevYearLink = $year;
$nextYearLink = $year;

if ($prevMonthLink == 0) {
    $prevMonthLink = 12;
    $prevYearLink--;
}
if ($nextMonthLink == 13) {
    $nextMonthLink = 1;
    $nextYearLink++;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mindful Journey</title>
    <link rel="stylesheet" href="css/kalender.css" />
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
        <div class="calendar-container">
          <div class="calendar-header">
            <h2 class="calendar-title"><?php echo $monthName . ' ' . $year; ?></h2>
            <div class="calendar-nav">
              <a href="?month=<?php echo $prevMonthLink; ?>&year=<?php echo $prevYearLink; ?>" class="nav-button">Previous</a>
              <a href="?month=<?php echo $nextMonthLink; ?>&year=<?php echo $nextYearLink; ?>" class="nav-button">Next</a>
            </div>
          </div>

          <table class="calendar-grid">
            <thead>
              <tr>
                <th>Sun</th>
                <th>Mon</th>
                <th>Tue</th>
                <th>Wed</th>
                <th>Thu</th>
                <th>Fri</th>
                <th>Sat</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $dayCount = 1;
              $currentDay = date('j');
              $currentMonth = date('n');
              $currentYear = date('Y');

              // Membuat calendar grid
              for ($i = 0; $i < 6; $i++) {
                  echo "<tr>";
                  for ($j = 0; $j < 7; $j++) {
                      if (($i == 0 && $j < $firstDay) || ($dayCount > $daysInMonth)) {
                          if ($i == 0 && $j < $firstDay) {
                              $prevMonthDay = $daysInPrevMonth - ($firstDay - $j - 1);
                              echo "<td class='other-month'>$prevMonthDay</td>";
                          } else {
                              $nextMonthDay = $dayCount - $daysInMonth;
                              echo "<td class='other-month'>$nextMonthDay</td>";
                              $dayCount++;
                          }
                      } else {
                          $class = '';
                          if ($dayCount == $currentDay && $month == $currentMonth && $year == $currentYear) {
                              $class = ' class="current"';
                          }
                          echo "<td$class>$dayCount</td>";
                          $dayCount++;
                      }
                  }
                  echo "</tr>";
                  if ($dayCount > $daysInMonth && $i != 5) break;
              }
              ?>
            </tbody>
          </table>
        </div>

        <div class="notes-container">
          <div class="notes-header">
            <h2 class="notes-title">Notes</h2>
            <button id="addNoteBtn" class="add-note-button">Add Note</button>
          </div>

          <?php
          // Di sini Anda bisa menambahkan logika untuk mengambil catatan dari database
          $notes = [
              ['time' => '9:00 AM', 'text' => 'Meeting with team'],
              ['time' => '2:30 PM', 'text' => 'Project deadline review'],
              ['time' => '4:00 PM', 'text' => 'Client call']
          ];
          ?>

          <div class="notes-list">
            <?php
            try {
                date_default_timezone_set('Asia/Jakarta');
                setlocale(LC_TIME, 'id_ID');
                
                $sql = "SELECT * FROM notes ORDER BY note_time DESC";
                $stmt = $koneksi->query($sql);
                while ($note = $stmt->fetch_assoc()) {
                    $time = date('H:i', strtotime($note['note_time']));
                    $date = strftime('%d %B %Y', strtotime($note['note_time']));
                    ?>
                    <div class="note-item">
                        <div class="note-actions">
                            <!-- <button class="action-btn edit-btn" data-id="<?php echo $note['id']; ?>">
                                <i class="fas fa-pencil-alt"></i>
                            </button> -->
                            <button class="action-btn delete-btn" data-id="<?php echo $note['id']; ?>">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        <div class="note-content">
                            <div class="note-time">
                                <span class="date"><?php echo htmlspecialchars($date); ?></span>
                                <span class="time"><?php echo htmlspecialchars($time); ?></span>
                            </div>
                            <div class="note-text"><?php echo htmlspecialchars($note['note_text']); ?></div>
                        </div>
                    </div>
                    <?php
                }
            } catch(Exception $e) {
                echo "Error: " . $e->getMessage();
            }
            ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Tambahkan modal HTML tepat sebelum closing tag </body> -->
    <div id="noteModal" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <h2>Create New Note</h2>
          <span class="close">&times;</span>
        </div>
        <div class="modal-body">
          <form id="noteForm">
            <div class="form-group">
              <textarea id="noteText" placeholder="Write your thoughts" required></textarea>
            </div>
            <button type="submit" class="save-btn">Save</button>
          </form>
        </div>
      </div>
    </div>

    <script>
    let selectedDate = new Date().toISOString().split('T')[0]; // Default ke hari ini

    // Fungsi untuk mengatur tanggal yang dipilih
    function setSelectedDate(date) {
        selectedDate = date;
        document.getElementById('noteDate').value = date;
    }

    // Update event click pada tanggal di kalender
    document.querySelectorAll('.calendar-grid td:not(.other-month)').forEach(td => {
        td.addEventListener('click', function() {
            const day = this.textContent;
            const date = `<?php echo $year ?>-<?php echo str_pad($month, 2, '0', STR_PAD_LEFT) ?>-${String(day).padStart(2, '0')}`;
            setSelectedDate(date);
        });
    });

    // Fungsi untuk membuka modal
    function openModal() {
        const modal = document.getElementById("noteModal");
        if (modal) {
            modal.style.display = "block";
            // Set tanggal default ke hari ini jika belum dipilih
            if (!document.getElementById('noteDate').value) {
                const today = new Date().toISOString().split('T')[0];
                document.getElementById('noteDate').value = today;
            }
        } else {
            console.error("Modal tidak ditemukan");
        }
    }

    // Tunggu sampai DOM selesai dimuat
    document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('noteModal');
    const btn = document.getElementById('addNoteBtn');
    const span = document.getElementsByClassName('close')[0];
    const form = document.getElementById('noteForm');
    let editMode = false;
    let currentNoteId = null;

    btn.onclick = function() {
        openModal();
    }

    span.onclick = function() {
        closeModal();
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            closeModal();
        }
    }

    function openModal(note = null) {
        if (note) {
            document.getElementById('noteText').value = note.text;
            currentNoteId = note.id;
            editMode = true;
        } else {
            form.reset();
            currentNoteId = null;
            editMode = false;
        }
        modal.style.display = "block";
    }

    function closeModal() {
        modal.style.display = "none";
        form.reset();
        currentNoteId = null;
        editMode = false;
    }

    form.onsubmit = function(e) {
        e.preventDefault();
        const text = document.getElementById('noteText').value;
        const url = editMode ? 'update_note.php' : 'save_note.php';
        const body = editMode ? `id=${currentNoteId}&text=${encodeURIComponent(text)}` : `text=${encodeURIComponent(text)}`;

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: body
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                if (editMode) {
                    const noteItem = document.querySelector(`.note-item[data-id="${data.data.id}"]`);
                    noteItem.querySelector('.note-content div:last-child').innerText = data.data.text;
                } else {
                    const notesList = document.querySelector('.notes-list');
                    const newNote = document.createElement('div');
                    newNote.className = 'note-item';
                    newNote.dataset.id = data.data.id;
                    newNote.innerHTML = `
                        <div class="note-content">
                            <div style="color: #008CBA; margin-bottom: 8px;">
                                ${data.data.date} ${data.data.time}
                            </div>
                            <div>
                                ${data.data.text}
                            </div>
                        </div>
                        <div class="note-actions">
                            <button class="action-btn edit-btn" data-id="${data.data.id}">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button class="action-btn delete-btn" data-id="${data.data.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `;
                    notesList.insertBefore(newNote, notesList.firstChild);
                    addEditEventListener(newNote);
                }
                closeModal();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    function addEditEventListener(noteItem) {
        noteItem.querySelector('.edit-btn').addEventListener('click', function() {
            const note = {
                id: this.getAttribute('data-id'),
                text: noteItem.querySelector('.note-content div:last-child').innerText
            };
            openModal(note);
        });
    }

    // Add event listeners to existing notes
    document.querySelectorAll('.note-item').forEach(addEditEventListener);
});

        const modal = document.getElementById('noteModal');
        const btn = document.getElementById('addNoteBtn');
        const span = document.getElementsByClassName('close')[0];
        const form = document.getElementById('noteForm');

        btn.onclick = function() {
            modal.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Event listener untuk tombol delete
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const noteId = this.getAttribute('data-id');
                const noteItem = this.closest('.note-item');
                
                fetch('delete_note.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'id=' + noteId
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        noteItem.remove();
                    } else {
                        console.error('Gagal menghapus note:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });

        // Event listener untuk note baru yang ditambahkan
        document.querySelector('.notes-list').addEventListener('click', function(e) {
            const deleteBtn = e.target.closest('.delete-btn');
            if (deleteBtn) {
                e.preventDefault();
                e.stopPropagation();
                
                const noteId = deleteBtn.getAttribute('data-id');
                const noteItem = deleteBtn.closest('.note-item');
                
                fetch('delete_note.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'id=' + noteId
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        noteItem.remove();
                    } else {
                        console.error('Gagal menghapus note:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        });

        // Form submission untuk menambah note baru
        form.onsubmit = function(e) {
            e.preventDefault();
            const text = document.getElementById('noteText').value;
            
            fetch('save_note.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'text=' + encodeURIComponent(text)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    const notesList = document.querySelector('.notes-list');
                    const newNote = document.createElement('div');
                    newNote.className = 'note-item';
                    newNote.innerHTML = `
                        <div class="note-content">
                            <div style="color: #008CBA; margin-bottom: 8px;">
                                ${data.data.date} ${data.data.time}
                            </div>
                            <div>
                                ${data.data.text}
                            </div>
                        </div>
                        <div class="note-actions">
                            <button class="action-btn edit-btn" data-id="${data.data.id}">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button class="action-btn delete-btn" data-id="${data.data.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `;
                    notesList.insertBefore(newNote, notesList.firstChild);
                    
                    form.reset();
                    modal.style.display = "none";
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        };

    // Format waktu dari 24h ke 12h format
    function formatTime(time) {
        const [hours, minutes] = time.split(':');
        const period = hours >= 12 ? 'PM' : 'AM';
        const hour12 = hours % 12 || 12;
        return `${hour12}:${minutes} ${period}`;
    }
    </script>
  </body>
</html> 