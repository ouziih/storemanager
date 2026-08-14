# 📓 Journal de Développement (DEVLOG)
**Nom & Prénom** : Ousmane Samba  
**Projet** : StoreManager Pro (ERP PHP/POO)  

---

## 1. Suivi Chronologique des Phases

### 🌃 [Vendredi - Phase 1] : Conception & BDD Fallback
- **Heure de réalisation** : 15h - 21h
- **Ce qui a été fait** : Les diagramme des cas d'utilisations et le diagramme des classes.
Avant de réaliser le travail j'ai passé la majeur partie du temps a parcourir les ecrans et essayer de sortir les relations
- **Difficultés / Obstacles** : J'ai un probleme d'incoherence des ecrans, sur l'ecran dashboard on peut voir la liste des produits dont le stock est critique
ou epuisé, on a l'option de demande d'approvisionnement automatique pour un produit. 
Sur tous les ecrans il n'y pas un autre formulaire pour créer un appro donc j'en ai deduis que chaque appro ne peut avoit qu'un seul ligneAppro ce qui est problematique, mais pourtant sur l'ecran approvisionnement on voit un appro avec deux ligneAppro. C'est ca qui m'a vraiment fait transpirer
en realisant le diagramme de classe j'ai considéré ce qu'on a fait avant  c'est a dire un appro peut avoir plusieurs ligneAppro.
Aussi en modelisant je ne savais pas comment reprsenter les permissions des utilisateurs en fonctions des pages mais c'est bon.
Voila les difficultés que j'ai rencontré en faisant le livrable Step 1.1 .