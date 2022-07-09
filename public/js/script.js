async function deleteUser(id) {
    let response = await fetch(`delete/${id}`)
    let data = response.json()
    console.log(data)
    if (data) {
        document.getElementById(`${id}`).remove()
    }
}

