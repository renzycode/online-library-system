<div class="form-group col-2 mb-0">
    <label class="col-form-label">Author 1
        <span class="text-danger"><em>(required)</em></span>
    </label>
    <select class="form-select" size="3" aria-label="size 3 select example">
        <?php
            foreach($authors as $author){
                $author_full_name = $author['author_fname'].' '.$author['author_lname'];
                echo '
                    <option value="'.$author_full_name.'">'.$author_full_name.'</option>
                ';
            }
            ?>
    </select>
</div>