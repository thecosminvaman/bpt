/**
 * Filters JavaScript
 * 
 * AJAX filtering and autocomplete for book archive
 * 
 * @package Biblioteca_Pentru_Toti
 */

(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', initFilters);

    function initFilters() {
        initAutocomplete();
        initLiveFiltering();
        initFilterPersistence();
    }

    /**
     * Autocomplete for Author Search
     */
    function initAutocomplete() {
        const input = document.getElementById('filter-autor-search');
        const hiddenInput = document.getElementById('filter-autor');
        const resultsContainer = document.getElementById('autor-results');
        
        if (!input || !resultsContainer) return;

        let debounceTimer;

        input.addEventListener('input', function() {
            const query = this.value.trim();
            
            clearTimeout(debounceTimer);
            
            if (query.length < 2) {
                resultsContainer.innerHTML = '';
                resultsContainer.classList.remove('is-visible');
                return;
            }

            debounceTimer = setTimeout(() => {
                fetchAutocompleteResults(query);
            }, 300);
        });

        // Close on outside click
        document.addEventListener('click', function(e) {
            if (!input.contains(e.target) && !resultsContainer.contains(e.target)) {
                resultsContainer.classList.remove('is-visible');
            }
        });

        // Keyboard navigation
        input.addEventListener('keydown', function(e) {
            const items = resultsContainer.querySelectorAll('.autocomplete-item');
            const active = resultsContainer.querySelector('.autocomplete-item.is-active');
            
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                if (active) {
                    const next = active.nextElementSibling;
                    if (next) {
                        active.classList.remove('is-active');
                        next.classList.add('is-active');
                    }
                } else if (items.length) {
                    items[0].classList.add('is-active');
                }
            }
            
            if (e.key === 'ArrowUp') {
                e.preventDefault();
                if (active) {
                    const prev = active.previousElementSibling;
                    if (prev) {
                        active.classList.remove('is-active');
                        prev.classList.add('is-active');
                    }
                }
            }
            
            if (e.key === 'Enter') {
                e.preventDefault();
                if (active) {
                    selectAuthor(active);
                }
            }
            
            if (e.key === 'Escape') {
                resultsContainer.classList.remove('is-visible');
            }
        });

        async function fetchAutocompleteResults(query) {
            try {
                const response = await fetch(
                    `${bptAjax.ajaxUrl}?action=bpt_autocomplete_authors&query=${encodeURIComponent(query)}&nonce=${bptAjax.nonce}`
                );
                
                if (!response.ok) throw new Error('Network error');
                
                const data = await response.json();
                
                if (data.success && data.data.length) {
                    renderResults(data.data);
                } else {
                    resultsContainer.innerHTML = '<div class="autocomplete-empty">Nu am găsit rezultate</div>';
                    resultsContainer.classList.add('is-visible');
                }
            } catch (error) {
                console.error('Autocomplete error:', error);
            }
        }

        function renderResults(authors) {
            resultsContainer.innerHTML = authors.map(author => `
                <button type="button" 
                        class="autocomplete-item" 
                        data-slug="${author.slug}"
                        data-name="${author.name}">
                    <span class="author-name">${author.name}</span>
                    <span class="author-count">${author.count} ${author.count === 1 ? 'carte' : 'cărți'}</span>
                </button>
            `).join('');
            
            resultsContainer.classList.add('is-visible');
            
            // Add click handlers
            resultsContainer.querySelectorAll('.autocomplete-item').forEach(item => {
                item.addEventListener('click', () => selectAuthor(item));
            });
        }

        function selectAuthor(item) {
            input.value = item.dataset.name;
            hiddenInput.value = item.dataset.slug;
            resultsContainer.classList.remove('is-visible');
        }
    }

    /**
     * Live Filtering (AJAX)
     */
    function initLiveFiltering() {
        const form = document.querySelector('.filters-form');
        const container = document.getElementById('books-container');
        const resultsCount = document.querySelector('.results-count');
        
        if (!form || !container) return;

        // Check if AJAX filtering is enabled
        if (!form.dataset.ajax) return;

        const selects = form.querySelectorAll('select');
        
        selects.forEach(select => {
            select.addEventListener('change', () => {
                loadFilteredBooks();
            });
        });

        async function loadFilteredBooks() {
            const formData = new FormData(form);
            formData.append('action', 'bpt_filter_books');
            formData.append('nonce', bptAjax.nonce);

            // Show loading state
            container.classList.add('is-loading');
            container.setAttribute('aria-busy', 'true');

            try {
                const response = await fetch(bptAjax.ajaxUrl, {
                    method: 'POST',
                    body: formData
                });
                
                if (!response.ok) throw new Error('Network error');
                
                const data = await response.json();
                
                if (data.success) {
                    container.innerHTML = data.data.html;
                    
                    if (resultsCount) {
                        resultsCount.textContent = data.data.count_text;
                    }
                    
                    // Update URL
                    const params = new URLSearchParams(formData);
                    params.delete('action');
                    params.delete('nonce');
                    const newUrl = `${window.location.pathname}?${params.toString()}`;
                    history.pushState(null, '', newUrl);
                    
                    // Reinit image hover effects
                    if (window.BPT && window.BPT.initImageHover) {
                        window.BPT.initImageHover();
                    }
                }
            } catch (error) {
                console.error('Filter error:', error);
            } finally {
                container.classList.remove('is-loading');
                container.setAttribute('aria-busy', 'false');
            }
        }
    }

    /**
     * Filter Persistence
     */
    function initFilterPersistence() {
        // Save filter state to session storage
        const form = document.querySelector('.filters-form');
        
        if (!form) return;

        // Restore filters on page load
        const savedFilters = sessionStorage.getItem('bpt_filters');
        if (savedFilters && window.location.search === '') {
            try {
                const filters = JSON.parse(savedFilters);
                Object.entries(filters).forEach(([name, value]) => {
                    const input = form.querySelector(`[name="${name}"]`);
                    if (input && value) {
                        input.value = value;
                    }
                });
            } catch (e) {
                console.error('Error restoring filters:', e);
            }
        }

        // Save filters on change
        form.addEventListener('change', () => {
            const formData = new FormData(form);
            const filters = {};
            
            for (const [key, value] of formData.entries()) {
                if (value) filters[key] = value;
            }
            
            sessionStorage.setItem('bpt_filters', JSON.stringify(filters));
        });

        // Clear saved filters on reset
        const resetBtn = form.querySelector('.filter-reset');
        if (resetBtn) {
            resetBtn.addEventListener('click', () => {
                sessionStorage.removeItem('bpt_filters');
            });
        }
    }

})();
