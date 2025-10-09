document.addEventListener("DOMContentLoaded", () => {
    const rows = document.querySelectorAll(".item");
    rows.forEach(item => {
        item.addEventListener("click", () => {
            const id = item.dataset.id;
            const path = item.dataset.path;

            window.location.href = `/${path}/${id}`
        })
    })

    const editBtn = document.querySelector(".edit");
    if (editBtn) {
        editBtn.addEventListener("click", () => {
            document.querySelector("form").classList.toggle("hidden")
        })
    }

    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute("content")

    const changeStatusBtn = document.querySelector(".change_status")
    if (changeStatusBtn) {
        changeStatusBtn.addEventListener("click", async () => {
            const id = changeStatusBtn.dataset.id;
            const path = changeStatusBtn.dataset.path;
            const action = path === "companies" ? "deactivate" : "hide"
            await fetch(`/${path}/${id}/${action}`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrf
                }
            }).then(r => window.location.reload())
        })
    }

    const deleteBtn = document.querySelector(".delete")
    if (deleteBtn) {
        deleteBtn.addEventListener("click", async () => {
            const id = deleteBtn.dataset.id;
            await fetch(`/products/${id}/delete`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": csrf
                }
            }).then(r => window.location.reload())
        })
    }

    const deleteImageBtn = document.querySelector(".delete_image")
    if (deleteImageBtn) {
        deleteImageBtn.addEventListener("click", async () => {
            const id = deleteImageBtn.dataset.id;
            await fetch(`/products/${id}/delete-image`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": csrf
                }
            }).then(r => window.location.reload())
        })
    }

    const fileInput = document.getElementById("file")
    fileInput.addEventListener("change", async () => {
        const id = fileInput.dataset.id;
        const file = fileInput.files[0]

        const formData = new FormData()
        formData.append("_token", csrf)
        formData.append("file", file)

        await fetch(`/products/${id}/upload-image`, {
            method: "POST",
            headers: {
                "Accept": "application/json",
                "X-CSRF-TOKEN": csrf
            },
            body: formData
        }).then(r => window.location.reload())
    })
})
