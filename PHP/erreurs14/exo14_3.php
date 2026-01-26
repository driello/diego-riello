<?php
// Exercice 3 : Logger

class Logger
{
    private string $logFile;

    public function __construct(string $logFile)
    {
        $this->logFile = $logFile;
    }

    private function log(string $niveau, string $message): void
    {
        $date = date('Y-m-d H:i:s');
        $ligne = "[{$date}] [{$niveau}] {$message}\n";
        file_put_contents($this->logFile, $ligne, FILE_APPEND);
    }

    public function debug(string $message): void
    {
        $this->log('DEBUG', $message);
    }

    public function info(string $message): void
    {
        $this->log('INFO', $message);
    }

    public function warning(string $message): void
    {
        $this->log('WARNING', $message);
    }

    public function error(string $message): void
    {
        $this->log('ERROR', $message);
    }

    public function critical(string $message): void
    {
        $this->log('CRITICAL', $message);
    }
}

echo "<h2>Exercice 3 : Logger</h2>";

$logger = new Logger(__DIR__ . '/app.log');

$logger->debug("Debug : début du script");
$logger->info("L'utilisateur Diego s'est connecté");
$logger->warning("Espace disque faible");
$logger->error("Erreur lors de la connexion à la base de données");
$logger->critical("Panne critique du serveur");

echo "<p>Quelques messages ont été écrits dans le fichier <strong>app.log</strong> dans le dossier <code>erreurs14</code>.</p>";
