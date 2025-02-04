<?php
$title = 'Archive';
ob_start();
?>
<style>
    .htmx-indicator {
        opacity: 0;
        transition: none !important;
    }

    .htmx-request .htmx-indicator {
        opacity: 1;
    }

    .htmx-request.htmx-indicator {
        opacity: 1;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const semesterSelect = document.getElementById('semesterSelect');
        const movieList = document.getElementById('movieList');

        // Restore state on page load
        const savedSemester = localStorage.getItem('selectedSemester');
        if (savedSemester) {
            semesterSelect.value = savedSemester;
            // Trigger HTMX request to load movies
            htmx.trigger(semesterSelect, 'change');
        }

        document.body.addEventListener('htmx:beforeRequest', function (event) {
            if (event.detail.elt.id === 'semesterSelect') {
                document.getElementById('movieList').innerHTML = '';
                // Save selected semester to localStorage
                localStorage.setItem('selectedSemester', semesterSelect.value);
            }
        });

        document.body.addEventListener('htmx:afterSettle', function (event) {
            if (event.detail.elt.id === 'semesterSelect') {
                // Save the movie list HTML to localStorage
                localStorage.setItem('movieListHTML', movieList.innerHTML);
                // Update browser history
                const url = new URL(window.location);
                url.searchParams.set('semester', semesterSelect.value);
                history.pushState({ semester: semesterSelect.value }, '', url);
            }
        });

        // Handle popstate event (when user clicks back/forward)
        window.addEventListener('popstate', function (event) {
            if (event.state && event.state.semester) {
                semesterSelect.value = event.state.semester;
                const savedMovieList = localStorage.getItem('movieListHTML');
                if (savedMovieList) {
                    movieList.innerHTML = savedMovieList;
                } else {
                    htmx.trigger(semesterSelect, 'change');
                }
            }
        });
    });
</script>
<div class="w-full h-full">
    <div class="max-w-5xl relative m-auto">
        <h1 class="my-4 text-6xl">Archive</h1>
        <label for="semesterSelect" class="block mt-4 mb-2">Sélectionner un semestre:</label>
        <select id="semesterSelect" name="semestre" class="border p-2 rounded" hx-get="/cinemutc/archive"
            hx-trigger="change" hx-target="#movieList" hx-indicator="#loadingIndicator">
            <option value="">Semestre</option>
            <?php foreach ($semestres as $semestre): ?>
                <option value="<?= htmlspecialchars($semestre); ?>"><?= htmlspecialchars($semestre); ?></option>
            <?php endforeach; ?>
        </select>
        <div id="loadingIndicator"
            class="htmx-indicator fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" class="w-16 h-16">
                <circle fill="#A6A6A6" stroke="#A6A6A6" stroke-width="15" r="15" cx="40" cy="65">
                    <animate attributeName="cy" calcMode="spline" dur="2" values="65;135;65;"
                        keySplines=".5 0 .5 1;.5 0 .5 1" repeatCount="indefinite" begin="-.4"></animate>
                </circle>
                <circle fill="#A6A6A6" stroke="#A6A6A6" stroke-width="15" r="15" cx="100" cy="65">
                    <animate attributeName="cy" calcMode="spline" dur="2" values="65;135;65;"
                        keySplines=".5 0 .5 1;.5 0 .5 1" repeatCount="indefinite" begin="-.2"></animate>
                </circle>
                <circle fill="#A6A6A6" stroke="#A6A6A6" stroke-width="15" r="15" cx="160" cy="65">
                    <animate attributeName="cy" calcMode="spline" dur="2" values="65;135;65;"
                        keySplines=".5 0 .5 1;.5 0 .5 1" repeatCount="indefinite" begin="0"></animate>
                </circle>
            </svg>
        </div>
        <div id="movieList" class="flex flex-wrap my-8 gap-2 items-stretch justify-center">
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
require BASE_PATH . '/app/views/layout.php';
?>
