# 📓 Journal de Développement (DEVLOG)
**Nom & Prénom** : Ousmane Samba  
**Projet** : StoreManager Pro (ERP PHP/POO)  

---

## 1. Suivi Chronologique des Phases

### 🌃 [Vendredi - Phase 1] : Conception & BDD Fallback
- **Heure de réalisation** : 15h - 21h | 
- **Ce qui a été fait** : Les diagramme des cas d'utilisations et le diagramme des classes.
Avant de réaliser le travail j'ai passé la majeur partie du temps a parcourir les ecrans et essayer de sortir les relations
- **Difficultés / Obstacles** : J'ai un probleme d'incoherence des ecrans, sur l'ecran dashboard on peut voir la liste des produits dont le stock est critique
ou epuisé, on a l'option de demande d'approvisionnement automatique pour un produit. 
Sur tous les ecrans il n'y pas un autre formulaire pour créer un appro donc j'en ai deduis que chaque appro ne peut avoit qu'un seul ligneAppro ce qui est problematique, mais pourtant sur l'ecran approvisionnement on voit un appro avec deux ligneAppro. C'est ca qui m'a vraiment fait transpirer
en realisant le diagramme de classe j'ai considéré ce qu'on a fait avant  c'est a dire un appro peut avoir plusieurs ligneAppro.
Aussi en modelisant je ne savais pas comment reprsenter les permissions des utilisateurs en fonctions des pages mais c'est bon.
Voila les difficultés que j'ai rencontré en faisant le livrable Step 1.1 .

- **Heure de réalisation** : 22h - 23h | 
- **Ce qui a été fait** : Les scriptsSQL 
- **Difficultés / Obstacles** : cette partie n'a pas etait difficile car je traduisais juste les classes en table mais je pense aux classes a réaliser

- **Heure de réalisation** : 23h - 12h du lendemain
- **Ce qui a été fait** : Singleton Database & Fallback Automatique 
- **Difficultés / Obstacles** : en commencant cette partie j'ai compris qu'il y'avait beaucoup de concepts puissants cachés derrieres
j'etais obligé de le voir un par un et de rater le delai.
c'est a cette partie que j'ai reelemene compris pourquoi vous nous avez demandé d'utilisé sqlite et aussi que ce que j'avais fait pour le livrable precedant sur sqlite n'etait pas bonne mais je l'ai corrigé 
j'ai compris les notions de fallback singleton mais je ne savais pas comment seront les deux bases c'est a dire si elles seront toujours synchro ou non 
c'etait compliqué pour moi de comprendre l'opérateur de résolution de portée , le role de static et sa consequence 

### ☀️ [Samedi - Phase 2] : POO, Repositories & Ventes POS
- **Heure de réalisation** : 12h - 14h
- **Ce qui a été fait** :  Entités POO Pure
- **Difficultés / Obstacles** : je me suis rappelé de ce que vous disiez en classe c'est a dire qu'une clé etrangere est representée par un objet et j'ai appliqué ce principe mais le souci est de faire require par ci ou par la ce qui n'est propre je pars sur le principe de tout mettre dans index ou les repos
le principe de l'encapsulation n'est pas compliqué a comprendre bien vrai que les consequences en declarant une visibilité sont profondes mais dans l'ensemble l'idée de proteger et de controller l'acces est claire pour moi 
seule les fonctions metiers m'ont paru compliqué car je ne savais pas qu'elle fonction mettre ou le mettre son role essentiel mais tout est claire maintenant 
j'ai oublier de pousser le commit Singleton Database & Fallback Automatique  donc les deux pousser auront les memes heures mais ca ne s'est pas realisé en meme temps
