function addSubject() {
 const div = document.createElement("div");
 div.classList.add("flex", "items-center", "gap-2", "mt-2");
 div.innerHTML = `
      <input type="text" name="subjects[]" placeholder="Subject name" required
        class="flex-1 px-3 py-2 rounded-md border border-indigo-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-indigo-700 dark:text-white" />
      <button type="button" onclick="removeSubject(this)" title="Remove"
        class="text-red-500 hover:text-red-700 text-lg">&times;</button>
    `;
 document.getElementById("subjectFields").appendChild(div);
}

function removeSubject(btn) {
 btn.parentElement.remove();
}