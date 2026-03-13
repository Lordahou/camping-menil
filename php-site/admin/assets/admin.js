// Mobile sidebar toggle
document.addEventListener('DOMContentLoaded', function () {
    var hamburger = document.getElementById('hamburger');
    var sidebar = document.getElementById('sidebar');
    var overlay = document.getElementById('sidebarOverlay');

    if (hamburger && sidebar) {
        hamburger.addEventListener('click', function () {
            sidebar.classList.toggle('open');
            if (overlay) overlay.classList.toggle('active');
        });
    }
    if (overlay) {
        overlay.addEventListener('click', function () {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
        });
    }

    // Auto-dismiss alerts after 4 seconds
    document.querySelectorAll('.alert').forEach(function (el) {
        setTimeout(function () {
            el.style.transition = 'opacity .3s';
            el.style.opacity = '0';
            setTimeout(function () { el.remove(); }, 300);
        }, 4000);
    });
});

/**
 * Add a new row to a dynamic list (FAQ, testimonials, tarifs, etc.)
 * @param {string} containerId  ID of the container element
 * @param {string} templateHtml  HTML template for new row (use __INDEX__ as placeholder)
 */
function addRow(containerId, templateHtml) {
    var container = document.getElementById(containerId);
    if (!container) return;
    var index = container.querySelectorAll('.item-row').length;
    var html = templateHtml.replace(/__INDEX__/g, index);
    var wrapper = document.createElement('div');
    wrapper.innerHTML = html;
    container.appendChild(wrapper.firstElementChild);
}

/**
 * Remove a dynamic row
 */
function removeRow(button) {
    var row = button.closest('.item-row');
    if (row && confirm('Supprimer cet élément ?')) {
        row.remove();
        // Re-index remaining rows
        var container = row.parentElement;
        if (container) reindexRows(container);
    }
}

/**
 * Remove a table row
 */
function removeTableRow(button) {
    var row = button.closest('tr');
    if (row && confirm('Supprimer cette ligne ?')) {
        row.remove();
    }
}

/**
 * Add a table row for tarifs
 */
function addTarifRow(tbodyId, section) {
    var tbody = document.getElementById(tbodyId);
    if (!tbody) return;
    var idx = tbody.querySelectorAll('tr').length;
    var tr = document.createElement('tr');
    tr.innerHTML =
        '<td><input type="text" name="tarifs[' + section + '][' + idx + '][label]" placeholder="Libellé" required></td>' +
        '<td><input type="text" name="tarifs[' + section + '][' + idx + '][price]" placeholder="Prix" required></td>' +
        '<td><button type="button" class="btn btn-danger btn-sm" onclick="removeTableRow(this)">Supprimer</button></td>';
    tbody.appendChild(tr);
}

/**
 * Re-index name attributes after row removal
 */
function reindexRows(container) {
    var rows = container.querySelectorAll('.item-row');
    rows.forEach(function (row, i) {
        row.querySelectorAll('[name]').forEach(function (input) {
            input.name = input.name.replace(/\[\d+\]/, '[' + i + ']');
        });
    });
}
