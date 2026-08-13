<!DOCTYPE html>
<html>
<head>
  <title>Library Attendance & Book RFID</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="{{ asset('css/attendance/scan.css') }}">
  <link href="{{ asset('vendor/fontsource/poppins/latin-400.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/fontsource/poppins/latin-600.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/fontsource/poppins/latin-700.css') }}" rel="stylesheet">
  <style>
    /* Footer marquee styling */
    .marquee-container {
      width: 100%;
      overflow: hidden;
      background-color: #222; /* dark footer */
      color: #fff;
      border-top: 2px solid #444;
      padding: 15px 0; /* slightly taller footer */
      box-sizing: border-box;
    }
    
    .marquee {
      display: inline-block;
      white-space: nowrap;
      padding-left: 100%; /* start offscreen */
      animation: scroll-text 15s linear infinite;
      font-family: 'Poppins', sans-serif;
      font-weight: 700;   /* bolder */
      font-size: 24px;    /* bigger font */
    }
    
    @keyframes scroll-text {
      0% { transform: translateX(0%); }
      100% { transform: translateX(-100%); }
    }
    </style>
</head>
<body>
  <header>
    <div class="header">
      <div class="logo-title">
        <img src="{{ asset('images/pantasLogo.png') }}" alt="Logo">
        <div id="pow" class="system-title">POWERED BY PANTAS</div>
        <a href="{{ route('book.index') }}" class="home-button" hidden>Home</a>
      </div>
    </div>
  </header>

  <div class="main">
    <div class="sidebar">
      <div class="date" id="currentDate">Date</div>
      <div class="time" id="currentTime">--:--:--</div>

      <div class="profile-pic">
        @if(isset($student) && $student->profile_picture)
          <img src="{{ asset($student->profile_picture) }}" alt="Profile">
        @else
          <img src="{{ asset('images/2x2_undifined_gender.jpg') }}" alt="Default Profile">
        @endif
      </div>

      <!-- ✅ Student log -->
      @if(isset($student))
        <div class="name-box">
          <div class="student-name">{{ $student->firstname }} {{ $student->lastname }}</div>
          <div class="label">Name</div>
          <div class="status-button {{ strtolower($status) === 'out' ? 'status-out' : '' }}">
            {{ $status }}
          </div>
          <div class="timestamp">
            {{ isset($log) ? \Carbon\Carbon::parse($log->scanned_at)->format('Y-m-d h:i:s A') : '' }}
          </div>
        </div>
      @endif

      <!-- ✅ Book check -->
      @if(isset($book))
        <div class="name-box">
          <div class="student-name">{{ $book->title_statement }}</div>
          <div class="label">Book Title</div>
          <div class="status-button {{ strtolower($bookStatus) === 'not checked out' ? 'status-out' : '' }}">
            {{ $bookStatus }}
          </div>
        </div>
      @endif

      <!-- ❌ Error -->
      @if(session('error'))
        <div class="name-box">
          <div class="student-name">{{ session('error') }}</div>
          <div class="label">Error</div>
        </div>
      @endif

    </div>

    <div class="right-content">
        <form id="scanForm">
            @csrf
            <textarea name="qrcode" id="qrcode" style="opacity:0; position:absolute;" autofocus autocomplete="off"></textarea>
        </form>


      <video muted autoplay loop controls class="ads-vid">
        <source src="{{ asset('videos/area51_product_slideshow.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
      </video>
    </div>
  </div>

    <!-- Footer with smooth scrolling marquee -->
    <footer>
      <div class="footer1">
        <div class="footer-logo">
          <div class="marquee-container">
            <div class="marquee">
              Welcome to Agusan College Inc.
            </div>
          </div>
        </div>
      </div>
    </footer>


  <!-- ✅ Add alert sound -->
  <audio id="alertSound" src="{{ asset('sounds/alert.wav') }}" type="audio/wav"></audio>
  
  
    <!-- ============================= -->
    <!-- FEEDBACK MODAL (FOR LOGOUT) -->
    <!-- ============================= -->
    <!--<div id="feedbackModal" class="section-modal">-->
    <!--  <div class="modal-content feedback-card">-->
    <!--    <h2>How was your library experience?</h2>-->
    
    <!--    <div class="feedback-options">-->
    <!--      <button data-rating="excellent">😊<span>Excellent</span></button>-->
    <!--      <button data-rating="good">🙂<span>Good</span></button>-->
    <!--      <button data-rating="medium">😐<span>Medium</span></button>-->
    <!--      <button data-rating="poor">🙁<span>Poor</span></button>-->
    <!--      <button data-rating="very_bad">😠<span>Very Bad</span></button>-->
    <!--    </div>-->
    
    <!--    <button id="declineFeedback" class="decline-btn">Skip</button>-->
    <!--  </div>-->
    <!--</div>-->

  <script>
      
    // const feedbackModal = document.getElementById('feedbackModal');
    let currentStudentId = null;
    
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('qrcode');
        const profileImg = document.querySelector('.profile-pic img');
        const sidebar = document.querySelector('.sidebar');
        const alertSound = document.getElementById('alertSound');
        let isCooldown = false;
        setInterval(() => input.focus(), 100);
        input.focus();
    
        function clearDisplay() {
            profileImg.src = "{{ asset('images/2x2_undifined_gender.jpg') }}";
            const boxes = document.querySelectorAll('.name-box');
            boxes.forEach(box => box.remove());
        }
    
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                if (isCooldown) return;
                isCooldown = true;
                setTimeout(() => isCooldown = false, 100);
    
                const formData = new FormData();
                // Remove extra newlines and trim each line
                let qrValue = input.value.trim().replace(/\r/g, ''); 
                formData.append('qrcode', qrValue);

                formData.append('_token', '{{ csrf_token() }}');
    
                fetch("{{ route('attendance.process') }}", {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    clearDisplay();
    
                    if (data.type === 'student') {
                        currentStudentId = data.student_id;
                        profileImg.src = "{{ asset('') }}" + data.student.profile_picture;
    
                        const div = document.createElement('div');
                        div.classList.add('name-box');
                        div.innerHTML = `
                            <div class="student-name">${data.student.firstname} ${data.student.lastname}</div>
                            <div class="label">Name</div>
                            <div class="status-button ${data.status.toLowerCase() === 'out' ? 'status-out' : ''}">${data.status}</div>
                            <div class="timestamp">${data.log.scanned_at}</div>
                        `;
                        sidebar.appendChild(div);
                        if (data.status.toLowerCase() === 'out') {
                            // setTimeout(() => {
                            //     feedbackModal.style.display = 'flex';
                            // }, 500);
                        }
                    } 
                    else if (data.type === 'book') {
                        if (data.bookStatus.toLowerCase() === 'not checked out') alertSound.play();
    
                        const div = document.createElement('div');
                        div.classList.add('name-box');
                        div.innerHTML = `
                            <div class="student-name">${data.book.title_statement}</div>
                            <div class="label">Book Title</div>
                            <div class="status-button ${data.bookStatus.toLowerCase() === 'not checked out' ? 'status-out' : ''}">${data.bookStatus}</div>
                        `;
                        sidebar.appendChild(div);
                    }
                    else if (data.type === 'error') {
                        const div = document.createElement('div');
                        div.classList.add('name-box');
                        div.innerHTML = `
                            <div class="student-name">${data.message}</div>
                            <div class="label">Error</div>
                        `;
                        sidebar.appendChild(div);
                    }
    
                    input.value = '';
                    setTimeout(clearDisplay, 2000);
                })
                .catch(err => console.error(err));
            }
        });
    });
    
    document.addEventListener('DOMContentLoaded', function() {
        function updateDateTime() {
            const now = new Date();
            const options = { weekday: 'long', year:'numeric', month:'long', day:'numeric' };
    
            const dateEl = document.getElementById('currentDate');
            const timeEl = document.getElementById('currentTime');
    
            if (dateEl && timeEl) {
                dateEl.textContent = now.toLocaleDateString('en-GB', options);
                timeEl.textContent = now.toLocaleTimeString('en-US');
            }
        }
    
        updateDateTime();
        setInterval(updateDateTime, 1000);
    });
    
    // =======================
    // FEEDBACK SYSTEM
    // =======================
    
    const feedbackButtons = document.querySelectorAll('.feedback-options button');
    const declineBtn = document.getElementById('declineFeedback');
    
    function sendFeedback(rating = null, declined = 0) {
    
        fetch("{{ route('attendance.feedback.store') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                student_id: currentStudentId,
                rating: rating,
                declined: declined
            })
        });
    
        feedbackModal.style.display = "none";
    }
    
    feedbackButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            sendFeedback(this.dataset.rating);
        });
    });
    
    declineBtn.addEventListener('click', function() {
        sendFeedback(null, 1);
    });
  </script>
</body>
</html>
