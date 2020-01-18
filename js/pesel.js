function correctPesel(pesel) {
    if (pesel.length !== 11) return false;
    var weights = [1, 3, 7, 9];
    var digits = pesel.split("");
    var sum = 0;
    for (i = 0; i < 10; i++) {
        sum += digits[i] * weights[i % 4];
    }
    sum %= 10;
    return (sum === 0 && digits[10] == 0) || (digits[10] == 10 - sum)
}

function peselToSex() {
    var digits = pesel.split("");
    var a = Number(digits[9]);
    if (a%2 == 0)return 'F';
    else return 'M';
}