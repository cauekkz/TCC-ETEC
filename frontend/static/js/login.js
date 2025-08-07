async function login(email, password) {
    const body = {
        email: email,
        password: password,
    }

    const response = await fetch("/api/login", {
        method: 'POST',
        body: JSON.stringify(body)
    })

    if (!response.ok) {
        //500
    }
    const data = await response.json()
    return data

}

function setCookie(name, value, minutes) {
    const date = new Date();
    date.setTime(date.getTime() + (minutes * 60 * 1000));
    const expires = "expires=" + date.toUTCString();
    document.cookie = name + "=" + value + ";" + expires + ";path=/";
}

