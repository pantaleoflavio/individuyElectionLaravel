import './bootstrap';

import * as bootstrap from 'bootstrap';

document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners to table headers
    document.querySelectorAll('th[data-sort]').forEach(function(header) {
        header.style.cursor = 'pointer'; // Add cursor pointer

        header.addEventListener('click', function() {
            var table = header.closest('table');
            var tbody = table.querySelector('tbody');
            var rows = Array.from(tbody.querySelectorAll('tr'));
            var sortKey = header.getAttribute('data-sort');
            var order = header.getAttribute('data-order') || 'asc';
            var sortedRows = rows.sort(function(a, b) {
                var aValue = a.querySelector('td:nth-child(' + (Array.from(header.parentNode.children).indexOf(header) + 1) + ')').textContent.trim();
                var bValue = b.querySelector('td:nth-child(' + (Array.from(header.parentNode.children).indexOf(header) + 1) + ')').textContent.trim();
                return order === 'asc' ? aValue.localeCompare(bValue) : bValue.localeCompare(aValue);
            });

            // Toggle the order
            order = order === 'asc' ? 'desc' : 'asc';
            header.setAttribute('data-order', order);

            // Clear existing arrow indicators
            document.querySelectorAll('th[data-sort]').forEach(function(th) {
                th.innerHTML = th.innerHTML.replace(/ ▲| ▼/g, '');
            });

            // Add the arrow indicator
            header.innerHTML += order === 'asc' ? ' ▲' : ' ▼';

            tbody.innerHTML = '';
            sortedRows.forEach(function(row) {
                tbody.appendChild(row);
            });
        });
    });
});

