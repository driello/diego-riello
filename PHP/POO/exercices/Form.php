<?php

// Classe représentant un formulaire HTML
class Form
{
    // Propriété qui contiendra le HTML du formulaire
    private string $formHtml;

    // Constructeur : on crée le début du formulaire
    public function __construct(string $action, string $method = 'post')
    {
        $this->formHtml  = "<form action=\"$action\" method=\"$method\">\n";
        $this->formHtml .= "  <fieldset>\n";
    }

    // Ajoute une zone de texte (input type="text")
    public function setText(string $name, string $label, string $placeholder = '', string $id = '')
    {
        // Si pas d'id fourni, on utilise le name
        if ($id === '') {
            $id = $name;
        }

        $this->formHtml .= "    <p>\n";
        $this->formHtml .= "      <label for=\"$id\">$label</label>\n";
        $this->formHtml .= "      <input type=\"text\" name=\"$name\" id=\"$id\" placeholder=\"$placeholder\">\n";
        $this->formHtml .= "    </p>\n";
    }

    // Ajoute un bouton de soumission
    public function setSubmit(string $value = 'Envoyer', string $name = 'submit')
    {
        $this->formHtml .= "    <p>\n";
        $this->formHtml .= "      <input type=\"submit\" name=\"$name\" value=\"$value\">\n";
        $this->formHtml .= "    </p>\n";
    }

    // Retourne tout le code HTML du formulaire (avec les balises fermantes)
    public function getForm(): string
    {
        $html  = $this->formHtml;
        $html .= "  </fieldset>\n";
        $html .= "</form>\n";

        return $html;
    }
}

// -------- Utilisation / test --------

// Création d'un formulaire qui envoie vers "traitement.php" en POST
$form = new Form('traitement.php', 'post');

// Ajout de deux champs texte
$form->setText('nom', 'Votre nom :', 'Entrez votre nom');
$form->setText('email', 'Votre email :', 'Entrez votre email');

// Ajout du bouton d'envoi
$form->setSubmit('Envoyer le formulaire');

// Affichage du formulaire
echo $form->getForm();
