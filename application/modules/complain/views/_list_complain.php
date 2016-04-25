
<li >
    <div class="list-group">
        <?php foreach ($quejas as $queja): ?>
            <a href="#" class="list-group-item list-complain-sigep" data-frips="<?php echo $queja->frips; ?>" data-tipoepid="<?php echo $queja->tipoep_id; ?>">
                <h4 class="list-group-item-heading"><?php echo $queja->radicado; ?></h4>
                <p class="list-group-item-text"><?php echo $queja->solicitante; ?></p>
                <p class="list-group-item-text"><?php echo $queja->solicitante_email; ?></p>
                <p class="list-group-item-text"> <?php echo word_limiter($queja->comentario, 10); ?> </p>
                <p class="list-group-item-text"> <?php echo $queja->fecha; ?> </p>
            </a>
        <?php endforeach; ?>
    </div>
</li>
