(function () {
    const jsonUrl = document.querySelector('meta[name="media-library-json"]')?.getAttribute('content');
    if (!jsonUrl) {
        return;
    }

    let cache = null;

    function loadLibrary() {
        if (cache) {
            return Promise.resolve(cache);
        }
        return fetch(jsonUrl, { headers: { 'Accept': 'application/json' } })
            .then((res) => res.json())
            .then((data) => {
                cache = data.images || [];
                return cache;
            })
            .catch(() => []);
    }

    function selectedLabel(count, multiple) {
        if (count === 0) {
            return 'None selected';
        }
        if (!multiple) {
            return '1 image selected';
        }
        return count + ' image(s) selected';
    }

    function bindPicker(root) {
        if (root.dataset.bound === '1') {
            return;
        }
        root.dataset.bound = '1';
        const multiple = root.dataset.multiple === '1';
        const existingName = root.dataset.existingName || 'existing_media_ids[]';
        const grid = root.querySelector('.media-picker-grid');
        const idsWrap = root.querySelector('.media-picker-ids');
        const label = root.querySelector('.media-picker-selected');
        const selected = new Set();

        function syncInputs() {
            idsWrap.innerHTML = '';
            selected.forEach((id) => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = existingName;
                input.value = id;
                idsWrap.appendChild(input);
            });
            label.textContent = selectedLabel(selected.size, multiple);
        }

        function render(images) {
            if (!images.length) {
                grid.innerHTML = '<p class="text-muted small mb-0">No images in the media library yet. Upload new files or add some under Media Images.</p>';
                return;
            }
            grid.innerHTML = '<div class="row g-2"></div>';
            const row = grid.querySelector('.row');
            images.forEach((image) => {
                const col = document.createElement('div');
                col.className = 'col-4 col-md-3';
                col.innerHTML = `
                    <button type="button" class="btn p-0 w-100 border rounded overflow-hidden media-picker-thumb ${selected.has(String(image.id)) ? 'border-primary' : ''}" data-id="${image.id}" title="${image.name || ''}">
                        <img src="${image.url}" alt="" style="width:100%;height:72px;object-fit:cover;display:block;">
                    </button>`;
                row.appendChild(col);
            });
        }

        grid.addEventListener('click', (e) => {
            const btn = e.target.closest('.media-picker-thumb');
            if (!btn) return;
            const id = String(btn.getAttribute('data-id'));
            if (multiple) {
                if (selected.has(id)) selected.delete(id);
                else selected.add(id);
            } else {
                selected.clear();
                selected.add(id);
            }
            grid.querySelectorAll('.media-picker-thumb').forEach((el) => {
                el.classList.toggle('border-primary', selected.has(el.getAttribute('data-id')));
            });
            syncInputs();
        });

        const libraryTab = root.querySelector('[data-bs-target$="-library"]');
        const load = () => loadLibrary().then(render);
        if (libraryTab) {
            libraryTab.addEventListener('shown.bs.tab', load);
        }
        load();
        syncInputs();
    }

    function init() {
        document.querySelectorAll('.media-picker').forEach(bindPicker);
    }

    document.addEventListener('DOMContentLoaded', init);
    document.addEventListener('livewire:navigated', () => {
        cache = null;
        document.querySelectorAll('.media-picker').forEach((el) => { el.dataset.bound = '0'; });
        init();
    });
    window.initMediaPickers = init;
})();
