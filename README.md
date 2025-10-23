#  Vendor_Partners — Module Magento 2

##  Objectif

Le module **Vendor_Partners** ajoute une **nouvelle entité de gestion "Partenaires"** dans le back-office Magento 2.  
Il permet à l’administrateur de créer, modifier et supprimer des partenaires commerciaux, chacun ayant :
- un **nom**
- un **logo**
- une **URL**
- une **date de début de partenariat**
- (bonus) un **statut actif/inactif**

Les partenaires actifs peuvent ensuite être affichés sur le **front-office** via un bloc dédié.

---

##  Fonctionnalités principales

###  Côté Back-office
- Nouveau menu dans **Marketing > Partners**.
- Grille d’administration (UI Component Grid) listant les partenaires.
- Formulaire d’ajout/édition (UI Component Form) complet avec gestion du **logo uploadé**.
- Gestion du statut **Actif/Inactif**.

### Côté Front-office
- Bloc `ActivePartners` affichant la liste des partenaires **actifs**.
- Affichage du nom, du logo et du lien vers le site du partenaire.

### Base de données
Création automatique de la table `vendor_partners` :
| Champ        | Type        | Description                     |
|---------------|-------------|---------------------------------|
| `partner_id`  | int(11) AI  | Identifiant unique              |
| `name`        | varchar(255)| Nom du partenaire               |
| `logo`        | varchar(255)| Chemin du fichier logo          |
| `url`         | varchar(255)| Lien vers le site partenaire    |
| `start_date`  | date        | Date de début du partenariat    |
| `is_active`   | boolean     | Statut du partenaire (optionnel)|

---

## Installation

### Copier le module
Placez le dossier complet dans :
```
app/code/Vendor/Partners
```

### Activer le module
Depuis la racine de votre projet Magento :
```bash
bin/magento module:enable Vendor_Partners
```

### Mettre à jour la base de données
```bash
bin/magento setup:upgrade
```

### (Optionnel) Nettoyer le cache
```bash
bin/magento cache:flush
```

### Vérifier que le module est actif
```bash
bin/magento module:status Vendor_Partners
```

---
##  Structure du module

```
Vendor/
└── Partners/
    ├── registration.php
    ├── etc/
    │   ├── module.xml
    │   ├── db_schema.xml
    │   └── adminhtml/
    │       └── menu.xml
    ├── Model/
    │   ├── Partner.php
    │   └── ResourceModel/
    │       ├── Partner.php
    │       └── Partner/
    │           └── Collection.php
    ├── Block/
    │   └── ActivePartners.php
    ├── view/
    │   ├── adminhtml/
    │   │   ├── layout/
    │   │   │   ├── partners_index.xml
    │   │   │   └── partners_edit.xml
    │   │   ├── ui_component/
    │   │   │   ├── partners_listing.xml
    │   │   │   └── partners_form.xml
    │   │   └── templates/
    │   │       └── edit.phtml
    │   └── frontend/
    │       └── templates/
    │           └── active_partners.phtml
    └── Test/
        └── Unit/
            ├── Model/
            │   ├── PartnerTest.php
            │   └── ResourceModel/
            │       ├── PartnerTest.php
            │       └── Partner/CollectionTest.php
            └── Integration/
                └── Setup/
                    └── InstallSchemaTest.php
```

---

## 🧪 Tests unitaires

Des **tests PHPUnit** sont fournis pour valider les comportements clés du module :  
- `Model/PartnerTest.php` → Test des getters/setters du modèle.  
- `Model/ResourceModel/PartnerTest.php` → Test de la configuration de la ResourceModel.  
- `Model/ResourceModel/Partner/CollectionTest.php` → Vérifie la configuration de la collection.  
- `Integration/Setup/InstallSchemaTest.php` → Vérifie l'installation de la base de données.  
---

# Bloc Frontend

### Exemple d’utilisation dans un template :
```php
<?php
/** @var \Vendor\Partners\Block\ActivePartners $block */
$partners = $block->getActivePartners();
?>
<div class="partners">
    <?php foreach ($partners as $partner): ?>
        <div class="partner">
            <img src="<?= $partner->getLogo() ?>" alt="<?= $partner->getName() ?>">
            <a href="<?= $partner->getUrl() ?>" target="_blank"><?= $partner->getName() ?></a>
        </div>
    <?php endforeach; ?>
</div>
```

---

## Bonnes pratiques respectées

- Respect des **normes PSR-12**
- Architecture **modulaire Magento 2**
- Utilisation du **DI (Dependency Injection)**
- **Séparation claire** du modèle, resource model et collection
- UI Components pour le **Grid et le Form**
- Gestion sécurisée de l’**upload de fichiers**
- Couverture de code par des **tests unitaires**
- Documentation et code commenté

---

## 👨‍💻 Auteur
**Nom :** Yassine Ghilani  
**Projet :** Exercice Technique Magento 2 – Gestion des Partenaires  

