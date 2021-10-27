<form method="post" action="editPerson.php<?php isset($person) ? '?id='.$person->getId() : ''  ?>">

    <input type="hidden" name="id" value="<?php echo isset($person) ? $person->getId() : null ?>">
    <input type="hidden" name="placement_id" value="<?php echo isset($placement) ? $placement->getId() : null ?>">

    <label for="name">Name</label>
    <input type="text" name="name" id="name" required="required" value="<?php echo isset($person) ? $person->getName() : null ?>"><br>

    <label for="surname">Surname</label>
    <input type="text" name="surname" id="surname" required="required" value="<?php echo isset($person) ? $person->getSurname() : null ?>"><br>

    <label for="birth_day">Birth day</label>
    <input type="text" name="birth_day" id="birth_day" required="required" placeholder="DD.MM.YYYY" value="<?php echo isset($person) ? $person->getBirthDay() : null ?>" pattern="^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[13-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$" ><br>

    <label for="birth_place">Birth place</label>
    <input type="text" name="birth_place" id="birth_place" required="required" value="<?php echo isset($person) ? $person->getBirthPlace() : null ?>"><br>

    <label for="birth_country">Birth country</label>
    <input type="text" name="birth_country" id="birth_country" required="required" value="<?php echo isset($person) ? $person->GetBirthCountry() : null ?>"><br>

    <label for="death_day">Death day</label>
    <input type="text" name="death_day" id="death_day" placeholder="DD.MM.YYYY" value="<?php echo isset($person) ? $person->getDeathDay() : null ?>" pattern="^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[13-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$"><br>

    <label for="death_place">Death place</label>
    <input type="text" name="death_place" id="death_place" value="<?php echo isset($person) ? $person->getDeathPlace() : null ?>"><br>

    <label for="death_country">Death country</label>
    <input type="text" name="death_country" id="death_country" value="<?php echo isset($person) ? $person->getDeathCountry() : null ?>"><br>

    <input type="submit">
</form>