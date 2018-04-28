# Quick info
Password generator
PHP 5 or higher
Stand alone class, no dependencies
Gnu GPL 3 or later

# charzam-password-generator
Generates passwords for you to use.
You get 30 passwords listed and can pick anyone of them or refresh the page and get another 30.
If possible, use this code offline on your trusted computer.

If you provide no parameters then you get the default values: 
* variable length 16-64 characters
* characters from all 5 groups

# Parameters
* length = length of the passwords you want. 0 (default) gives you a random length 16-64 characters.
* max_group_number = numbers of groups to include in the password. 

            0 => 'abcdefghijklmnopqrstuvwxyz',
            1 => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            2 => '0123456789',
            3 => '!#%&()=?+-*:;,._',
            4 => ' ',

Default max_group_number = 4 (0-4)
Some sites do not allow spaces, then set max_group_number = 3
Some sites do not allow special chacaters, then set max_group_number = 2

# Random numbers
PHP 5 uses mt_rand(), an OK random generator
PHP 7 uses random_int(), a better random generator

# Examples
    http://charzam.com/password/?length=32&max_group_number=3
    http://charzam.com/password/?length=16&max_group_number=2

# Passwords - general caution
There is no souch thing as a good password. Passwords should never be used. But we are in a world filled with passwords, and the only thing we can do is to make it the passwords as secure as possible.
* Password is personal - do not let a group share a password.
* Password is private – do not share your password
* Password is unique - Never reuse it
* Password must be hard to guess - Use a good open source password generator that you trust
* Password should be used every time - Do not let your browser remember the password.
* Keep your password in an encrypted file locally stored – Do not use password managers like LastPass.

# License
Gnu GPL 3 or later
