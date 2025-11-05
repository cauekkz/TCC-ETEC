async function executeWithRefresh(func, ...args) {
    const data = await func(...args);
    if (data.status === "success") {
        return data;
    }
    if (data.status === "Logg in") {
        window.location.href = "/login"
    }
    const response = await fetch("/api/refreshToken")
    if (!response.ok) {
        window.location.href = "/login"
    }
    const refreshData = await response.json()
    console.log(refreshData)
    if (refreshData.status !== "success") {
        window.location.href = "/login"
    }
    localStorage.setItem("jwt_token", refreshData.data)
    const data2 = await func(...args);
    return data2;

}