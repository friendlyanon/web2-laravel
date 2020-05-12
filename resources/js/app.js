import "./bootstrap";

function filterMap(iterable, filter, map) {
  const results = [];

  for (let i = 0, { length } = iterable; i < length; ++i) {
    const value = iterable[i];
    if (filter(value, i)) {
      results.push(map(value, i));
    }
  }

  return results;
}

const isMultiple = /^\/(?:user|organization)s\/?$/ui.test(location.pathname);

/**
 * @param {HTMLTableElement} table
 * @param {HTMLInputElement} input
 */
function bootTable(table, input) {
  const previous = table.previousElementSibling;
  if (previous == null || !previous.classList.contains("table-bar")) {
    table.insertAdjacentHTML("beforebegin", `
<div class="mb-2 mt-3 d-flex table-bar" style="justify-content: flex-end">
    <div class="d-inline-block">
        <input type="text" class="form-control search-box"
               placeholder="Keresés">
    </div>
</div>
    `);
  }

  const rows = Array.from(
    table.querySelectorAll("tbody tr"),
    row => ({
      row,
      checkbox: row.querySelector(`input[type="checkbox"]`),
      texts: filterMap(
        row.querySelectorAll("td"),
        cell => cell.childElementCount === 0,
        cell => cell.textContent.trim(),
      ),
    }),
  );

  if (!rows.length || rows[0].checkbox == null) {
    return;
  }

  let timer;

  function searchRows(search) {
    timer = null;

    for (const { row, texts } of rows) {
      if (!search.value) {
        row.hidden = false;
      } else {
        row.hidden = !texts.some(x => x.includes(search.value));
      }
    }
  }

  /** @type {HTMLInputElement} */
  const columCheckbox = table.querySelector(`input[type="checkbox"]`);

  function rowCheckbox({ target }) {
    const checked = [];
    for (const row of rows) {
      if (!isMultiple && row.checkbox !== target) {
        row.checkbox.checked = false;
      }

      if (row.checkbox.checked) {
        checked.push(row.row.dataset.id);
      }
    }

    if (checked.length === 0) {
      columCheckbox.checked = false;
    } else if (isMultiple && checked.length < rows.length) {
      columCheckbox.indeterminate = true;
    } else {
      columCheckbox.checked = true;
    }

    input.value = checked.join(",");
  }

  /** @type {HTMLInputElement} */
  const search = table.previousElementSibling.querySelector(".search-box");
  search.addEventListener("input", function () {
    if (timer == null) {
      timer = setTimeout(searchRows, 100, search);
    }
  });

  for (const { checkbox } of rows) {
    checkbox.addEventListener("change", rowCheckbox);
  }

  columCheckbox.addEventListener("change", (e) => {
    if (e.target.checked || e.target.intermediate) {
      e.target.checked = e.target.intermediate = false;
      for (const { checkbox } of rows) {
        checkbox.checked = false;
      }
      input.value = "";
    } else if (!isMultiple) {
      const checked = [];
      for (const { checkbox, row } of rows) {
        checkbox.checked = true;
        checked.push(row.dataset.id);
      }
      input.value = checked.join(",");
    } else {
      e.preventDefault();
    }
  });

  let lastSort, asc = false;
  function sortByColumn() {
    const idx = Number(this.dataset.sort);

    const body = table.querySelector("tbody");
    const nodes = rows.map(x => [x.texts[idx], body.removeChild(x.row)]);
    const sorter = !asc && idx === lastSort ?
      (b, a) => a[0].localeCompare(b[0]) :
      (a, b) => a[0].localeCompare(b[0]);
    nodes.sort(sorter);
    if (idx === lastSort) {
      asc = !asc;
    } else {
      lastSort = idx;
      asc = false;
    }
    for (const [, node] of nodes) {
      body.appendChild(node);
    }
  }

  let i = 0;
  for (const th of table.querySelectorAll(`th[data-sort]`)) {
    th.dataset.sort = String(i++);
    th.addEventListener("click", sortByColumn);
  }
}

document.addEventListener("DOMContentLoaded", function () {
  const hiddenInputs = document.querySelectorAll(`input[type="hidden"][data-field]`);
  const tables = document.querySelectorAll(`table.table`);
  let i = 0;

  for (const table of tables) {
    bootTable(table, hiddenInputs[i++] || { value: "" });
  }
}, { once: true });
