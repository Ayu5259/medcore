@if ($errors->any())
<div>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
</head>

<body>

    <h1>Register</h1>

    <form method="POST" action="/register">

        @csrf

        <div>
            <label>First Name</label>
            <input type="text" name="first_name">
        </div>

        <div>
            <label>Last Name</label>
            <input type="text" name="last_name">
        </div>

        <div>
            <label>National Code</label>
            <input type="text" name="national_code">
        </div>

        <div>
            <label>Gender</label>
            <select name="gender">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="NonBinary">NonBinary</option>
            </select>
        </div>

        <div>
            <label>Birth Date</label>
            <input type="date" name="birth_date">
        </div>

        <div>
            <label>Phone</label>
            <input type="text" name="phone">
        </div>

        <!-- Country -->
        <div>
            <label for="country">Country</label>
            <input
                type="text"
                id="country"
                name="country"
                value="{{ old('country') }}">
        </div>

        <!-- Province -->
        <div>
            <label for="province">Province</label>
            <select id="province" name="province">
                <option value="">Select Province</option>
                <option value="Tehran" {{ old('province') == 'Tehran' ? 'selected' : '' }}>
                    Tehran
                </option>
                <option value="Alborz" {{ old('province') == 'Alborz' ? 'selected' : '' }}>
                    Alborz
                </option>
                <option value="Isfahan" {{ old('province') == 'Isfahan' ? 'selected' : '' }}>
                    Isfahan
                </option>
                <option value="Fars" {{ old('province') == 'Fars' ? 'selected' : '' }}>
                    Fars
                </option>
            </select>
        </div>

        <!-- City -->
        <div>
            <label for="city">City</label>
            <select id="city" name="city">
                <option value="">Select City</option>
                <option value="Tehran" {{ old('city') == 'Tehran' ? 'selected' : '' }}>
                    Tehran
                </option>
                <option value="Karaj" {{ old('city') == 'Karaj' ? 'selected' : '' }}>
                    Karaj
                </option>
                <option value="Isfahan" {{ old('city') == 'Isfahan' ? 'selected' : '' }}>
                    Isfahan
                </option>
                <option value="Shiraz" {{ old('city') == 'Shiraz' ? 'selected' : '' }}>
                    Shiraz
                </option>
            </select>
        </div>

        <!-- Address -->
        <div>
            <label for="address">Address</label>
            <textarea
                id="address"
                name="address"
                rows="4">{{ old('address') }}</textarea>
        </div>

        <!-- Postal Code -->
        <div>
            <label for="postal_code">Postal Code</label>
            <input
                type="text"
                id="postal_code"
                name="postal_code"
                value="{{ old('postal_code') }}">
        </div>

        <div>
            <label>Email</label>
            <input type="email" name="email">
        </div>

        <div>
            <label>Confirm Email</label>
            <input type="email" name="email_confirmation">
        </div>

        <div>
            <label>Password</label>
            <input type="password" name="password">
        </div>

        <div>
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation">
        </div>

        <button type="submit">Register</button>

    </form>

</body>

</html>