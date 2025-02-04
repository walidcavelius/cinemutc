<?php
$title = 'Programmation';
ob_start();
require_once BASE_PATH . '/app/helpers/auth_helper.php';
?>
<div class="w-full h-full">
	<div class="max-w-4xl relative m-auto">
		<h1 class="my-4 text-5xl">La ville</h1>
		<p>
			Ce cycle de projection est dédié à l'exploration cinématographique de la ville. À travers une
			sélection éclectique de films, nous plongerons dans les diverses façons dont les cinéastes
			capturent, interprètent et exploitent le décor urbain comme personnage à part entière.<br
			/><br /> Des ruelles pittoresques de "Amélie Poulain" à l'effervescence trépidante de "Made in
			Hongkong", en passant par les méandres architecturaux de "Playtime", chaque film offre une perspective
			unique sur la vie citadine. Ces œuvres explorent la ville en tant que reflet de la société, terrain
			de jeu de l'humour, cadre de quêtes épiques, ou encore toile de fond pour les drames et les intrigues.
			Joignez-vous à nous pour un voyage cinématographique captivant au cœur des métropoles, où les rues
			et les buildings deviennent le canevas sur lequel se dessinent des histoires inoubliables.
		</p>
		<h2>Les films projetés:
			<?php if (isAdmin()): ?>
				<a href="/admin/films" class="ml-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
					Gérer les films
				</a>
			<?php endif; ?>
		</h2>
	</div>
	<div class="my-8 flex justify-center flex-wrap gap-4">
		<?php
        foreach($movies as $movie) {
            $film = $movie;
            if (isAdmin()) {
                echo '<div class="relative">';
                echo '<button class="absolute top-2 right-2 bg-red-500 text-white p-2 rounded" onclick="removeFromProgrammation(' . $film['id'] . ')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>';
            }
            require BASE_PATH . '/app/views/components/film_card.php';
            if (isAdmin()) {
                echo '</div>';
            }
        }
        ?>
	</div>
</div>

<?php if (isAdmin()): ?>
<script>
function removeFromProgrammation(filmId) {
    if (confirm('Êtes-vous sûr de vouloir retirer ce film de la programmation ?')) {
        fetch('/api/programmation/remove', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ filmId: filmId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Une erreur est survenue');
            }
        });
    }
}
</script>
<?php endif; ?>

<?php
$content = ob_get_clean();
require BASE_PATH . '/app/views/layout.php';
?>
