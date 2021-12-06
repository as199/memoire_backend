<?php

namespace App\Services;

use App\Entity\Thematique;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class CartographieService
{

    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function getCartographieByAuditeur(int $id)
    {
        $utilisateur = $this->entityManager->getRepository(Utilisateur::class)->find($id);
        $notations = $utilisateur->getNotations();
        $notationsAR =[];
        $i=1;
        foreach ($notations as $notation){
            $notationsAR[$i]['thema'] =$notation->getCompetence()
                ->getThematique()->getLibelle();
            $notationsAR[$i]['comp_cnit'] = $notation->getCompetence()->getCompCnceIt();
            $notationsAR[$i]['libelle_comp'] = $notation->getCompetence()->getLibelle();
            $notationsAR[$i]['id_comp'] = $notation->getCompetence()->getId();
            $notationsAR[$i]['note'] = $notation->getNote();
            $notationsAR[$i]['id_note'] = $notation->getId();
            $notationsAR[$i]['periode'] = $notation->getPeriode()->format('Y-m-d');
            $notationsAR[$i]['id_aud'] = $notation->getUtilisateur()->getId();
            $notationsAR[$i]['nom_aud'] = $notation->getUtilisateur()->getNomComplet();
            $i++;
        }
        $data1 =[];
        foreach ($notationsAR as $key =>$notas){
            $this->is_inArray($data1, $notas['thema'], $notas);
        }
        $data2 =[];
        foreach($data1 as $key =>$notats1)
        {
            foreach($notats1 as $notats2){
                $this->is_inArray2($data2,$key, $notats2['comp_cnit'], $notats2);
            }
        }
        return $data2;
    }

    public function getCartographieByEntite(int $id)
    {
        $utilisateurs = $this->entityManager->getRepository(Utilisateur::class)->findBy(["entite"=>$id]);
        $notationss=[];
        foreach($utilisateurs as $utilisateur){
            $notationss[] = $utilisateur->getNotations();
        }
        $notationsAR= [];
        $i=1;
        foreach($notationss as $notations1){
            foreach ($notations1 as $notation){
                $notationsAR[$i]['thema'] =$notation->getCompetence()
                    ->getThematique()->getLibelle();
                $notationsAR[$i]['comp_cnit'] = $notation->getCompetence()->getCompCnceIt();
                $notationsAR[$i]['libelle_comp'] = $notation->getCompetence()->getLibelle();
                $notationsAR[$i]['id_comp'] = $notation->getCompetence()->getId();
                $notationsAR[$i]['note'] = $notation->getNote();
                $notationsAR[$i]['id_note'] = $notation->getId();
                $notationsAR[$i]['periode'] = $notation->getPeriode()->format('Y-m-d');
                $notationsAR[$i]['id_aud'] = $notation->getUtilisateur()->getId();
                $notationsAR[$i]['entite'] = $notation->getUtilisateur()->getEntite()->getLibelle();
                $notationsAR[$i]['nom_aud'] = $notation->getUtilisateur()->getNomComplet();
                $i++;
            }
        }
        $data1 =[];
        foreach ($notationsAR as $key =>$notas){
            $this->is_inArray($data1, $notas['thema'], $notas);
        }
        $data2 =[];
        foreach($data1 as $key =>$notats1)
        {
            foreach($notats1 as $notats2){
                $this->is_inArray2($data2,$key, $notats2['comp_cnit'], $notats2);
            }
        }
        return $data2;
    }

    public function getCartographieByDepartement(int $id)
    {
        $utilisateurs = $this->entityManager->getRepository(Utilisateur::class)->findBy(["departement"=>$id]);
        $notationss=[];
        foreach($utilisateurs as $utilisateur){
            $notationss[] = $utilisateur->getNotations();
        }
        $notationsAR= [];
        $i=1;
        foreach($notationss as $notations1){
            foreach ($notations1 as $notation){
                $notationsAR[$i]['thema'] =$notation->getCompetence()
                    ->getThematique()->getLibelle();
                $notationsAR[$i]['comp_cnit'] = $notation->getCompetence()->getCompCnceIt();
                $notationsAR[$i]['libelle_comp'] = $notation->getCompetence()->getLibelle();
                $notationsAR[$i]['id_comp'] = $notation->getCompetence()->getId();
                $notationsAR[$i]['note'] = $notation->getNote();
                $notationsAR[$i]['id_note'] = $notation->getId();
                $notationsAR[$i]['periode'] = $notation->getPeriode()->format('Y-m-d');
                $notationsAR[$i]['id_aud'] = $notation->getUtilisateur()->getId();
                $notationsAR[$i]['entite'] = $notation->getUtilisateur()->getEntite()->getLibelle();
                $notationsAR[$i]['nom_aud'] = $notation->getUtilisateur()->getNomComplet();
                $i++;
            }
        }
        $data1 =[];
        foreach ($notationsAR as $key =>$notas){
            $this->is_inArray($data1, $notas['thema'], $notas);
        }
        $data2 =[];
        foreach($data1 as $key =>$notats1)
        {
            foreach($notats1 as $notats2){
                $this->is_inArray2($data2,$key, $notats2['comp_cnit'], $notats2);
            }
        }
        return $data2;
    }


    protected function is_inArray(array &$data, $index, $value)
    {
        $data[$index][]= $value;
    }
    protected function is_inArray2(array &$data,$index1, $index, $value)
    {
        $data[$index1][$index][]= $value;
    }

}