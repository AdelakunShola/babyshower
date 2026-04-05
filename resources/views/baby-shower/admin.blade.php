<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Baby Shower Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'DM Sans', sans-serif; background: #f7f2ef; padding: 2rem; color: #3d2c26; }
        h1 { font-size: 1.5rem; font-weight: 500; margin-bottom: 1.5rem; }
        .stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 2rem; }
        .stat { background: #fff; border-radius: 14px; padding: 1.25rem 1.5rem; border: 1px solid #f0e4dc; }
        .stat .num { font-size: 2rem; font-weight: 500; }
        .stat .lbl { font-size: .8rem; color: #8a7066; margin-top: .25rem; }
        .stat.boy .num { color: #1a6fa3; }
        .stat.girl .num { color: #9c2b68; }
        table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 14px; overflow: hidden; border: 1px solid #f0e4dc; }
        th { text-align: left; padding: .75rem 1rem; font-size: .78rem; font-weight: 500; color: #8a7066; letter-spacing: .05em; text-transform: uppercase; border-bottom: 1px solid #f0e4dc; }
        td { padding: .75rem 1rem; font-size: .88rem; border-bottom: 1px solid #f7f2ef; }
        tr:last-child td { border-bottom: none; }
        .badge { display: inline-block; padding: .25rem .65rem; border-radius: 6px; font-size: .78rem; font-weight: 500; }
        .badge.boy  { background: #dff0fc; color: #1a6fa3; }
        .badge.girl { background: #fce4f0; color: #9c2b68; }
        video { width: 160px; border-radius: 8px; }
        .empty { text-align: center; padding: 3rem; color: #b08a7a; }
    </style>
</head>
<body>
<h1>🌸 Baby Shower — Submissions</h1>

<div class="stats">
    <div class="stat">
        <div class="num">{{ $submissions->count() }}</div>
        <div class="lbl">Total guesses</div>
    </div>
    <div class="stat boy">
        <div class="num">{{ $boyCount }}</div>
        <div class="lbl">Guessed boy 💙</div>
    </div>
    <div class="stat girl">
        <div class="num">{{ $girlCount }}</div>
        <div class="lbl">Guessed girl 💗</div>
    </div>
</div>

@if($submissions->isEmpty())
    <div class="empty">No submissions yet. Share the link!</div>
@else
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Guess</th>
            <th>Message</th>
            <th>Video</th>
            <th>Submitted</th>
        </tr>
    </thead>
    <tbody>
        @foreach($submissions as $s)
        <tr>
            <td>{{ $s->id }}</td>
            <td>{{ $s->name }}</td>
            <td>{{ $s->email ?? '—' }}</td>
            <td><span class="badge {{ $s->guess }}">{{ ucfirst($s->guess) }}</span></td>
            <td>{{ $s->message ?? '—' }}</td>
            <td>
                <video src="{{ route('baby-shower.video', $s) }}" controls></video>
            </td>
            <td>{{ $s->created_at->format('d M Y, H:i') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
</body>
</html>