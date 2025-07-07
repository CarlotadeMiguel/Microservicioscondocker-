@if(session('success'))
    <div style="color: green;">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div style="color: red;">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="/submit">
    @csrf
    <label>Name:</label>
    <input type="text" name="name" value="{{ old('name') }}" required><br>
    <label>Email:</label>
    <input type="email" name="email" value="{{ old('email') }}" required><br>
    <label>Message:</label>
    <textarea name="message" required>{{ old('message') }}</textarea><br>
    <input type="submit" value="Submit">
</form>
