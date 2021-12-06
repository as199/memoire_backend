<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211206173800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE certification_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE competence_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE departement_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE diplome_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE entite_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE evaluation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE fonction_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE mission_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE notation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE rapport_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reporting_codir_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE statut_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE suivi_activite_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE suivi_report_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE thematique_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE utilisateur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE certification (id INT NOT NULL, utilisateur_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, obtenu_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6C3C6D75FB88E14F ON certification (utilisateur_id)');
        $this->addSql('COMMENT ON COLUMN certification.obtenu_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE competence (id INT NOT NULL, thematique_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, status BOOLEAN NOT NULL, comp_cnce_it VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_94D4687F476556AF ON competence (thematique_id)');
        $this->addSql('CREATE TABLE departement (id INT NOT NULL, responsable_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, status BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C1765B6353C59D72 ON departement (responsable_id)');
        $this->addSql('CREATE TABLE diplome (id INT NOT NULL, utilisateur_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, obtenu_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_EB4C4D4EFB88E14F ON diplome (utilisateur_id)');
        $this->addSql('COMMENT ON COLUMN diplome.obtenu_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE entite (id INT NOT NULL, responsable_id INT DEFAULT NULL, departement_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, status BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1A29182753C59D72 ON entite (responsable_id)');
        $this->addSql('CREATE INDEX IDX_1A291827CCF9E01E ON entite (departement_id)');
        $this->addSql('CREATE TABLE evaluation (id INT NOT NULL, mission_id INT NOT NULL, libelle TEXT NOT NULL, evaluation TEXT NOT NULL, commentaire_aud_manager TEXT NOT NULL, commentaire_aud TEXT DEFAULT NULL, status BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1323A575BE6CAE90 ON evaluation (mission_id)');
        $this->addSql('COMMENT ON COLUMN evaluation.libelle IS \'(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN evaluation.evaluation IS \'(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN evaluation.commentaire_aud_manager IS \'(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN evaluation.commentaire_aud IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE fonction (id INT NOT NULL, libelle VARCHAR(255) NOT NULL, status BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE mission (id INT NOT NULL, responsable_id INT NOT NULL, entite_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, annee VARCHAR(255) NOT NULL, debut_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, fin_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, nbre_jr_reel INT NOT NULL, nbre_jr_prevu INT DEFAULT NULL, impact INT DEFAULT NULL, gravite INT DEFAULT NULL, taux_cim_teste DOUBLE PRECISION DEFAULT NULL, commentaire TEXT DEFAULT NULL, status BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9067F23C53C59D72 ON mission (responsable_id)');
        $this->addSql('CREATE INDEX IDX_9067F23C9BEA957A ON mission (entite_id)');
        $this->addSql('COMMENT ON COLUMN mission.debut_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN mission.fin_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE mission_utilisateur (mission_id INT NOT NULL, utilisateur_id INT NOT NULL, PRIMARY KEY(mission_id, utilisateur_id))');
        $this->addSql('CREATE INDEX IDX_7A832952BE6CAE90 ON mission_utilisateur (mission_id)');
        $this->addSql('CREATE INDEX IDX_7A832952FB88E14F ON mission_utilisateur (utilisateur_id)');
        $this->addSql('CREATE TABLE notation (id INT NOT NULL, competence_id INT NOT NULL, utilisateur_id INT NOT NULL, note INT NOT NULL, periode DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_268BC9515761DAB ON notation (competence_id)');
        $this->addSql('CREATE INDEX IDX_268BC95FB88E14F ON notation (utilisateur_id)');
        $this->addSql('CREATE TABLE rapport (id INT NOT NULL, mission_id INT NOT NULL, constats VARCHAR(255) NOT NULL, causes VARCHAR(255) NOT NULL, recommandation TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status BOOLEAN NOT NULL, rapport BYTEA DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_BE34A09CBE6CAE90 ON rapport (mission_id)');
        $this->addSql('COMMENT ON COLUMN rapport.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE reporting_codir (id INT NOT NULL, entite_id INT NOT NULL, semaine VARCHAR(255) NOT NULL, fonctionne TEXT NOT NULL, point_coordination TEXT NOT NULL, difficultes TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B6FCCC469BEA957A ON reporting_codir (entite_id)');
        $this->addSql('CREATE TABLE statut (id INT NOT NULL, libelle VARCHAR(255) NOT NULL, status BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE suivi_activite (id INT NOT NULL, statut_id INT NOT NULL, mission_id INT NOT NULL, semaine VARCHAR(255) NOT NULL, fait VARCHAR(255) DEFAULT NULL, reste_faire VARCHAR(255) DEFAULT NULL, difficultes VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1E4CC586F6203804 ON suivi_activite (statut_id)');
        $this->addSql('CREATE INDEX IDX_1E4CC586BE6CAE90 ON suivi_activite (mission_id)');
        $this->addSql('CREATE TABLE suivi_report (id INT NOT NULL, entite_id INT NOT NULL, report_recu TEXT DEFAULT NULL, report_valide TEXT DEFAULT NULL, report_rejete TEXT DEFAULT NULL, report_instance TEXT DEFAULT NULL, solde INT NOT NULL, creatad_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_66EB0AD69BEA957A ON suivi_report (entite_id)');
        $this->addSql('COMMENT ON COLUMN suivi_report.report_recu IS \'(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN suivi_report.report_valide IS \'(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN suivi_report.report_rejete IS \'(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN suivi_report.report_instance IS \'(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN suivi_report.creatad_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE thematique (id INT NOT NULL, libelle VARCHAR(255) NOT NULL, status BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE utilisateur (id INT NOT NULL, fonction_id INT DEFAULT NULL, entite_id INT DEFAULT NULL, departement_id INT NOT NULL, username VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, status BOOLEAN NOT NULL, nbr_jr_formation INT DEFAULT NULL, entree_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, sortie_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3F85E0677 ON utilisateur (username)');
        $this->addSql('CREATE INDEX IDX_1D1C63B357889920 ON utilisateur (fonction_id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B39BEA957A ON utilisateur (entite_id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B3CCF9E01E ON utilisateur (departement_id)');
        $this->addSql('COMMENT ON COLUMN utilisateur.entree_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN utilisateur.sortie_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE certification ADD CONSTRAINT FK_6C3C6D75FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE competence ADD CONSTRAINT FK_94D4687F476556AF FOREIGN KEY (thematique_id) REFERENCES thematique (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE departement ADD CONSTRAINT FK_C1765B6353C59D72 FOREIGN KEY (responsable_id) REFERENCES utilisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE diplome ADD CONSTRAINT FK_EB4C4D4EFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE entite ADD CONSTRAINT FK_1A29182753C59D72 FOREIGN KEY (responsable_id) REFERENCES utilisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE entite ADD CONSTRAINT FK_1A291827CCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575BE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C53C59D72 FOREIGN KEY (responsable_id) REFERENCES utilisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C9BEA957A FOREIGN KEY (entite_id) REFERENCES entite (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mission_utilisateur ADD CONSTRAINT FK_7A832952BE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mission_utilisateur ADD CONSTRAINT FK_7A832952FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE notation ADD CONSTRAINT FK_268BC9515761DAB FOREIGN KEY (competence_id) REFERENCES competence (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE notation ADD CONSTRAINT FK_268BC95FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rapport ADD CONSTRAINT FK_BE34A09CBE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reporting_codir ADD CONSTRAINT FK_B6FCCC469BEA957A FOREIGN KEY (entite_id) REFERENCES entite (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE suivi_activite ADD CONSTRAINT FK_1E4CC586F6203804 FOREIGN KEY (statut_id) REFERENCES statut (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE suivi_activite ADD CONSTRAINT FK_1E4CC586BE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE suivi_report ADD CONSTRAINT FK_66EB0AD69BEA957A FOREIGN KEY (entite_id) REFERENCES entite (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B357889920 FOREIGN KEY (fonction_id) REFERENCES fonction (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B39BEA957A FOREIGN KEY (entite_id) REFERENCES entite (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3CCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE notation DROP CONSTRAINT FK_268BC9515761DAB');
        $this->addSql('ALTER TABLE entite DROP CONSTRAINT FK_1A291827CCF9E01E');
        $this->addSql('ALTER TABLE utilisateur DROP CONSTRAINT FK_1D1C63B3CCF9E01E');
        $this->addSql('ALTER TABLE mission DROP CONSTRAINT FK_9067F23C9BEA957A');
        $this->addSql('ALTER TABLE reporting_codir DROP CONSTRAINT FK_B6FCCC469BEA957A');
        $this->addSql('ALTER TABLE suivi_report DROP CONSTRAINT FK_66EB0AD69BEA957A');
        $this->addSql('ALTER TABLE utilisateur DROP CONSTRAINT FK_1D1C63B39BEA957A');
        $this->addSql('ALTER TABLE utilisateur DROP CONSTRAINT FK_1D1C63B357889920');
        $this->addSql('ALTER TABLE evaluation DROP CONSTRAINT FK_1323A575BE6CAE90');
        $this->addSql('ALTER TABLE mission_utilisateur DROP CONSTRAINT FK_7A832952BE6CAE90');
        $this->addSql('ALTER TABLE rapport DROP CONSTRAINT FK_BE34A09CBE6CAE90');
        $this->addSql('ALTER TABLE suivi_activite DROP CONSTRAINT FK_1E4CC586BE6CAE90');
        $this->addSql('ALTER TABLE suivi_activite DROP CONSTRAINT FK_1E4CC586F6203804');
        $this->addSql('ALTER TABLE competence DROP CONSTRAINT FK_94D4687F476556AF');
        $this->addSql('ALTER TABLE certification DROP CONSTRAINT FK_6C3C6D75FB88E14F');
        $this->addSql('ALTER TABLE departement DROP CONSTRAINT FK_C1765B6353C59D72');
        $this->addSql('ALTER TABLE diplome DROP CONSTRAINT FK_EB4C4D4EFB88E14F');
        $this->addSql('ALTER TABLE entite DROP CONSTRAINT FK_1A29182753C59D72');
        $this->addSql('ALTER TABLE mission DROP CONSTRAINT FK_9067F23C53C59D72');
        $this->addSql('ALTER TABLE mission_utilisateur DROP CONSTRAINT FK_7A832952FB88E14F');
        $this->addSql('ALTER TABLE notation DROP CONSTRAINT FK_268BC95FB88E14F');
        $this->addSql('DROP SEQUENCE certification_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE competence_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE departement_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE diplome_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE entite_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE evaluation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE fonction_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE mission_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE notation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE rapport_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reporting_codir_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE statut_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE suivi_activite_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE suivi_report_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE thematique_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE utilisateur_id_seq CASCADE');
        $this->addSql('DROP TABLE certification');
        $this->addSql('DROP TABLE competence');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE diplome');
        $this->addSql('DROP TABLE entite');
        $this->addSql('DROP TABLE evaluation');
        $this->addSql('DROP TABLE fonction');
        $this->addSql('DROP TABLE mission');
        $this->addSql('DROP TABLE mission_utilisateur');
        $this->addSql('DROP TABLE notation');
        $this->addSql('DROP TABLE rapport');
        $this->addSql('DROP TABLE reporting_codir');
        $this->addSql('DROP TABLE statut');
        $this->addSql('DROP TABLE suivi_activite');
        $this->addSql('DROP TABLE suivi_report');
        $this->addSql('DROP TABLE thematique');
        $this->addSql('DROP TABLE utilisateur');
    }
}
