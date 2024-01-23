<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240123091055 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE answers (id INT AUTO_INCREMENT NOT NULL, answer LONGTEXT NOT NULL, vote INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comments (id INT AUTO_INCREMENT NOT NULL, answers_id INT DEFAULT NULL, comment LONGTEXT NOT NULL, INDEX IDX_5F9E962A79BF1BCE (answers_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questions (id INT AUTO_INCREMENT NOT NULL, question LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_questions (user_id INT NOT NULL, questions_id INT NOT NULL, INDEX IDX_8A3CD931A76ED395 (user_id), INDEX IDX_8A3CD931BCB134CE (questions_id), PRIMARY KEY(user_id, questions_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_answers (user_id INT NOT NULL, answers_id INT NOT NULL, INDEX IDX_8DDD80CA76ED395 (user_id), INDEX IDX_8DDD80C79BF1BCE (answers_id), PRIMARY KEY(user_id, answers_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A79BF1BCE FOREIGN KEY (answers_id) REFERENCES answers (id)');
        $this->addSql('ALTER TABLE user_questions ADD CONSTRAINT FK_8A3CD931A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_questions ADD CONSTRAINT FK_8A3CD931BCB134CE FOREIGN KEY (questions_id) REFERENCES questions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_answers ADD CONSTRAINT FK_8DDD80CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_answers ADD CONSTRAINT FK_8DDD80C79BF1BCE FOREIGN KEY (answers_id) REFERENCES answers (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A79BF1BCE');
        $this->addSql('ALTER TABLE user_questions DROP FOREIGN KEY FK_8A3CD931A76ED395');
        $this->addSql('ALTER TABLE user_questions DROP FOREIGN KEY FK_8A3CD931BCB134CE');
        $this->addSql('ALTER TABLE user_answers DROP FOREIGN KEY FK_8DDD80CA76ED395');
        $this->addSql('ALTER TABLE user_answers DROP FOREIGN KEY FK_8DDD80C79BF1BCE');
        $this->addSql('DROP TABLE answers');
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE questions');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_questions');
        $this->addSql('DROP TABLE user_answers');
    }
}
