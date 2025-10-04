document.addEventListener("DOMContentLoaded", () => {
    const addBtn = document.querySelector(".add");
    const checker_inner = document.querySelector(".checker_inner");

    addBtn.addEventListener("click", () => {
        const index = document.querySelectorAll(".form_label").length;
        const element = `<div class="form_label">
                    <label for="GTIN_${index + 1}">GTIN ${index + 1}:</label>
                    <input type="text" name="GTIN_${index + 1}" id="GTIN_${index+1}">
                </div>`
        checker_inner.insertAdjacentHTML('beforeend', element);
    })
})
