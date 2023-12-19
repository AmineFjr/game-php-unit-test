# Mon Projet

## Intégration Continue (CI)

- Lorsqu'une Pull Request (PR) est ouverte ou réouverte sur la branche principale, une série de tests et d'analyses sont automatiquement déclenchées. Ces étapes sont définies dans le fichier `.github/workflows/main-actions.yml`.

- Pour reproduire ces étapes localement, l'auteur de la PR peut exécuter les commandes suivantes :

```bash
wget https://phar.phpunit.de/phpunit-9.phar
chmod +x phpunit-9.phar
./phpunit-9.phar tests/GameTest.php
```

## Déploiement Continu (CD)
- Lorsqu'une modification est fusionnée dans la branche principale, une tâche de déploiement est automatiquement déclenchée. 
- Cette tâche est également définie dans le fichier .github/workflows/main-actions.yml. Le "livrable" produit par le CD est une version déployée de l'application.  
- Pour déployer une nouvelle version de l'application, le nouveau stagiaire, devra suivre ces étapes :  
1. Assurer que toutes les modifications ont été fusionnées dans la branche principale.
2. Créer un nouveau tag git qui commence par v, par exemple v1.2.3.
3. Pousse ce tag sur le dépôt GitHub. Cela déclenchera une tâche de livraison continue qui créera une nouvelle version de l'application et la déployera.
Voici les commandes que tu peux utiliser :

```bash
git checkout main
git pull
git tag v1.2.3
git push origin v1.2.3
```