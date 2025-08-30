async function login(email, password) {
    const body = {
        email: email,
        password: password,
    }

    try {
        const response = await fetch("/api/login", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(body)
        })

        if (!response.ok) {
            const errorData = await response.json();
            throw errorData;
        }
        
        const data = await response.json()
        return data
    } catch (error) {
        throw error;
    }
}

function setCookie(name, value, minutes) {
    const date = new Date();
    date.setTime(date.getTime() + (minutes * 60 * 1000));
    const expires = "expires=" + date.toUTCString();
    document.cookie = name + "=" + value + ";" + expires + ";path=/";
}

