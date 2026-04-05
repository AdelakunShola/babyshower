<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guess the Gender 🌸</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'DM Sans', sans-serif; min-height: 100vh; }

        .layout { display: grid; grid-template-columns: 1fr 1fr; min-height: 100vh; }

        /* LEFT PHOTO SIDE */
        .photo-side { position: relative; overflow: hidden; }
        .photo-side img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .photo-overlay { position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(20,10,5,.1), rgba(20,10,5,.55)); }
        .photo-caption { position: absolute; bottom: 2.5rem; left: 2rem; right: 2rem; color: #fff; }
        .photo-caption .tag { font-size: 10px; letter-spacing: .2em; text-transform: uppercase; opacity: .8; margin-bottom: .5rem; }
        .photo-caption h2 { font-family: 'Playfair Display', serif; font-size: 2rem; line-height: 1.2; font-weight: 400; }
        .photo-caption h2 em { font-style: italic; }
        .photo-caption p { font-size: .85rem; opacity: .75; margin-top: .4rem; }

        /* RIGHT FORM SIDE */
        .form-side { position: relative; overflow: hidden; }
        .form-bg { position: absolute; inset: 0; }
        .form-bg img {
            width: 100%; height: 100%;
            object-fit: cover; object-position: center top;
            display: block;
            filter: brightness(.38) saturate(.7);
        }
        .form-content {
            position: relative; z-index: 2;
            padding: 3rem 2.5rem;
            display: flex; flex-direction: column; justify-content: center;
            min-height: 100vh;
        }
        .form-inner { max-width: 400px; margin: 0 auto; width: 100%; }

        .form-tag { font-size: 10px; letter-spacing: .18em; text-transform: uppercase; color: #e8c4b0; font-weight: 500; margin-bottom: .6rem; }
        h1 { font-family: 'Playfair Display', serif; font-size: 1.9rem; color: #fff; line-height: 1.2; margin-bottom: .35rem; }
        h1 em { font-style: italic; color: #f4a07a; }
        .sub { font-size: .83rem; color: rgba(255,255,255,.65); margin-bottom: 1.75rem; line-height: 1.5; }

        .field { margin-bottom: 1rem; }
        label { display: block; font-size: .76rem; font-weight: 500; color: rgba(255,255,255,.7); letter-spacing: .04em; margin-bottom: .35rem; }
        .optional { color: rgba(255,255,255,.4); font-weight: 400; }

        input[type=text], input[type=email], textarea {
            width: 100%; border: 1px solid rgba(255,255,255,.2); border-radius: 10px;
            padding: .6rem .85rem; font-family: 'DM Sans', sans-serif;
            font-size: .88rem; color: #fff;
            background: rgba(255,255,255,.1);
            outline: none; transition: border .2s, background .2s;
            backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px);
        }
        input::placeholder, textarea::placeholder { color: rgba(255,255,255,.35); }
        input:focus, textarea:focus { border-color: rgba(244,160,122,.7); background: rgba(255,255,255,.15); }
        textarea { resize: none; height: 65px; }

        .error { color: #f4836a; font-size: .78rem; margin-top: .25rem; }

        .guess-row { display: grid; grid-template-columns: 1fr 1fr; gap: .6rem; }
        .guess-btn {
            display: flex; align-items: center; justify-content: center; gap: .4rem;
            padding: .65rem; border-radius: 10px;
            border: 1px solid rgba(255,255,255,.2);
            background: rgba(255,255,255,.1);
            cursor: pointer; font-family: 'DM Sans', sans-serif;
            font-size: .9rem; font-weight: 500; color: rgba(255,255,255,.8);
            transition: all .2s;
            backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px);
        }
        .guess-btn:hover { border-color: rgba(255,255,255,.5); background: rgba(255,255,255,.18); }
        .guess-btn.boy.active  { background: rgba(91,173,222,.3); border-color: #5badde; color: #a8d8f5; }
        .guess-btn.girl.active { background: rgba(229,123,178,.3); border-color: #e57bb2; color: #f5b8da; }

        .video-zone {
            border: 1.5px dashed rgba(255,255,255,.25); border-radius: 12px;
            padding: 1.25rem; text-align: center; cursor: pointer;
            transition: all .2s; background: rgba(255,255,255,.08);
            position: relative;
            backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px);
        }
        .video-zone:hover { border-color: rgba(244,160,122,.6); background: rgba(255,255,255,.13); }
        .video-zone p { font-size: .8rem; color: rgba(255,255,255,.6); }
        .video-zone strong { color: rgba(255,255,255,.9); }
        #video-input { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }

        .preview { margin-top: .6rem; display: none; }
        .preview video { width: 100%; border-radius: 8px; }

        .timer-bar { height: 3px; background: rgba(255,255,255,.15); border-radius: 2px; margin-top: .4rem; display: none; }
        .timer-fill { height: 100%; border-radius: 2px; background: #f4a07a; }
        .timer-label { font-size: .72rem; color: rgba(255,255,255,.5); text-align: right; margin-top: .2rem; display: none; }
        .warn { font-size: .72rem; color: #f4836a; margin-top: .3rem; display: none; }

        .submit-btn {
            width: 100%; padding: .8rem;
            background: rgba(255,255,255,.92); color: #3d2c26;
            border: none; border-radius: 10px; font-family: 'DM Sans', sans-serif;
            font-size: .95rem; font-weight: 500; cursor: pointer;
            transition: all .2s; margin-top: .75rem;
        }
        .submit-btn:hover { background: #fff; }
        .submit-btn:disabled { background: rgba(255,255,255,.25); color: rgba(255,255,255,.4); cursor: not-allowed; }

        .progress { display: none; text-align: center; margin-top: .6rem; font-size: .82rem; color: rgba(255,255,255,.55); }

        .alert-errors {
            background: rgba(244,131,106,.15); border: 1px solid rgba(244,131,106,.4);
            border-radius: 10px; padding: .75rem 1rem;
            margin-bottom: 1.25rem; font-size: .83rem; color: #f9b4a4;
        }

        @media (max-width: 768px) {
            .layout { grid-template-columns: 1fr; }
            .photo-side { height: 55vw; min-height: 220px; }
            .form-content { padding: 2rem 1.25rem; min-height: auto; }
        }
    </style>
</head>
<body>
<div class="layout">

    {{-- LEFT: Couple photo --}}
    <div class="photo-side">
        <img src="{{ asset('images/couple.jpg') }}" alt="The couple">
        <div class="photo-overlay"></div>
        <div class="photo-caption">
            <div class="tag">Baby shower · {{ date('Y') }}</div>
            <h2>Kolade & <em>Moyin</em></h2>
            <p>A new chapter begins 🌿</p>
        </div>
    </div>

    {{-- RIGHT: Form with couple photo background --}}
    <div class="form-side">
        <div class="form-bg">
            <img src="{{ asset('images/couple.jpg') }}" alt="">
        </div>

        <div class="form-content">
            <div class="form-inner">

                <div class="form-tag">Join the fun</div>
                <h1>Boy or <em>Girl</em>?</h1>
                <p class="sub">Record your guess — keep it under <strong style="color:rgba(255,255,255,.9)">40 seconds</strong>!</p>

                @if ($errors->any())
                    <div class="alert-errors">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('baby-shower.store') }}" method="POST" enctype="multipart/form-data" id="upload-form">
                    @csrf

                    <div class="field">
                        <label>Your name</label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Aunty Chioma" required>
                        @error('name') <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <div class="field">
                        <label>Email <span class="optional">(optional)</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com">
                    </div>

                    <div class="field">
                        <label>My guess is…</label>
                        <div class="guess-row">
                            <button type="button" class="guess-btn boy {{ old('guess') === 'boy' ? 'active' : '' }}" onclick="setGuess('boy',this)">💙 Boy</button>
                            <button type="button" class="guess-btn girl {{ old('guess') === 'girl' ? 'active' : '' }}" onclick="setGuess('girl',this)">💗 Girl</button>
                        </div>
                        <input type="hidden" name="guess" id="guess-val" value="{{ old('guess') }}">
                        @error('guess') <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <div class="field">
                        <label>Message <span class="optional">(optional)</span></label>
                        <textarea name="message" placeholder="A little note for the parents…">{{ old('message') }}</textarea>
                    </div>

                    <div class="field">
                        <label>Your video guess</label>
                        <div class="video-zone">
                            <input
                                type="file"
                                id="video-input"
                                name="video"
                                accept="video/*,.mov,.mp4,.m4v,.avi,.wmv,.mkv,.webm,.3gp,.3g2,.mts,.m2ts,.hevc"
                                onchange="handleVideo(this)"
                                required
                            >
                            <p style="font-size:1.4rem;margin-bottom:.3rem">🎬</p>
                            <p><strong>Click to upload or record</strong></p>
                            <p>All formats accepted · max 40s</p>
                        </div>
                        <div class="preview" id="preview-box">
                            <video id="preview-vid" controls playsinline></video>
                        </div>
                        <div class="timer-bar" id="timer-bar">
                            <div class="timer-fill" id="timer-fill"></div>
                        </div>
                        <div class="timer-label" id="timer-label"></div>
                        <div class="warn" id="dur-warn">⚠ Over 40 seconds — please trim and re-upload.</div>
                        @error('video') <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <button class="submit-btn" id="sub-btn" type="submit" disabled>Submit my guess →</button>
                    <div class="progress" id="progress-msg">Uploading your video, please wait…</div>

                </form>
            </div>
        </div>
    </div>

</div>

<script>
    let guess = '{{ old('guess') }}' || null;
    let validVideo = false;

    function setGuess(val, el) {
        guess = val;
        document.getElementById('guess-val').value = val;
        document.querySelectorAll('.guess-btn').forEach(b => b.classList.remove('active'));
        el.classList.add('active');
        check();
    }

    function handleVideo(input) {
        const file = input.files[0];
        if (!file) return;

        const vid = document.getElementById('preview-vid');
        vid.src = URL.createObjectURL(file);
        document.getElementById('preview-box').style.display = 'block';
        document.getElementById('timer-bar').style.display = 'block';
        document.getElementById('timer-label').style.display = 'block';

        vid.onloadedmetadata = function () {
            const d = vid.duration;
            const pct = Math.min((d / 40) * 100, 100);
            const fill = document.getElementById('timer-fill');
            const label = document.getElementById('timer-label');
            const warn = document.getElementById('dur-warn');

            fill.style.width = pct + '%';
            fill.style.background = d > 40 ? '#f4836a' : '#f4a07a';
            label.textContent = Math.round(d) + 's / 40s';

            if (d > 40) {
                warn.style.display = 'block';
                validVideo = false;
            } else {
                warn.style.display = 'none';
                validVideo = true;
            }
            check();
        };

        // Fallback for iPhone HEVC files that can't be previewed in browser
        vid.onerror = function () {
            validVideo = true;
            document.getElementById('timer-label').textContent = 'Preview not available — file accepted';
            check();
        };
    }

    function check() {
        const name = document.querySelector('input[name=name]').value.trim();
        document.getElementById('sub-btn').disabled = !(guess && validVideo && name);
    }

    document.querySelector('input[name=name]').addEventListener('input', check);

    document.getElementById('upload-form').addEventListener('submit', function () {
        document.getElementById('sub-btn').disabled = true;
        document.getElementById('sub-btn').textContent = 'Uploading…';
        document.getElementById('progress-msg').style.display = 'block';
    });
</script>
</body>
</html>