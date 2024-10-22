<?php
$title = 'Programmation';
ob_start();
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
		<h2>Les films projetés:</h2>
	</div>
	<div class="my-8 flex justify-center">
		<?php
        foreach($movies as $movie) {
            $film = $movie;
            require BASE_PATH . '/app/views/components/film_card.php';
        }
        ?>
	</div>
</div>
<?php
$content = ob_get_clean();
require BASE_PATH . '/app/views/layout.php';
?>