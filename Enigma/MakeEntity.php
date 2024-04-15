<?php 
namespace Enigma;

class MakeEntity{
    
    private $count_turn = 0;
    private $table_name;
    private $col_name =[];
    private $type_name = [];
    private $value =[];
    private $nullable =[];
    private $unique = [];

    public function __construct() {

        $this->GET_TABLE_NAME();
    }

    protected function GET_TABLE_NAME()
    {  
        @system('clear');
        echo " \n \t \t \033[31m/!\ POUR CHAQUE TABLE l'ID et CREATED_AT SERAS AUTOMATIQUEMENT CRÉÉ /!\\033[0m \n \n";
        echo "\033[1;33m\t \t Quelle nom auras votre table ?\033[0m\n \n";
        $table_name = trim(readline());

        if ($table_name == "" || $table_name == " ")
        {
            echo "\033[31mNom invalide ou vide\033[0m \n";
            self::GET_TABLE_NAME();
        }else
        {
            $this->table_name = $table_name;
            self::GET_COL_NAME();
        }


    }

    protected function GET_COL_NAME()
    { 
        echo "\033[1;33m\t \t Pour la table $this->table_name quelle seras le nom de votre collumn ?\033[0m\n  \n";
        $col_name = trim(readline());
        if ($col_name == "" || $col_name == " ")
        {
            echo "\033[31mNom invalide ou vide.\033[0m \n";
            self::GET_COL_NAME();
        }else{
            array_push($this->col_name, $col_name);
            self::GET_TYPE_NAME();
        }
        
    }

    protected function GET_TYPE_NAME()
    {
        echo "\033[1;33m\t \t Pour la collumn ".$this->col_name[$this->count_turn]." quelle seras le type ? (string default) or help for list\033[0m \n";
        $type_name = trim(readline("\t"));

        if ($type_name == "help")
        {
            echo "string \n text \n boolean \n int \n timestamp \n blob \n date \n";
            self::GET_TYPE_NAME();
        }

        if ($type_name == "" || $type_name == " ")
        {
            $type_name = 'string';
        }
            array_push($this->type_name, $type_name);
            if ($type_name == 'string')
            {
                self::GET_VALUE();
            }else{
                self::GET_NULLABLE();
            }
    }

    protected function GET_VALUE()
    {
        echo "\033[1;33m\t \t Combien de caractère maximum autorisé (255 default) ?\033[0m \n";
        $value = trim(readline());
        $key_value = $this->col_name[$this->count_turn];

        if ($value == "" || $value == " ")
        {
            $value = 255;
        }

            array_push($this->value, $value);
            self::GET_NULLABLE();
    }

    protected function GET_NULLABLE()
    {
        echo "\033[1;33m\t \t La collumn ".$this->col_name[$this->count_turn]." peut elle être null ? true/false (false default)\033[0m \n";
        $nullable = trim(readline());
        if ($nullable == "" || $nullable == " " || $nullable == 'false')
        {
            $nullable = 'false';
        }elseif ($nullable != "true") {
            $nullable = 'true';
        }
        array_push($this->nullable, $nullable);

       self::GET_UNIQUE();
    }

    public function GET_UNIQUE()
    {
        echo "\033[1;33m\t \t La collumn ".$this->col_name[$this->count_turn]." doit elle être unique ? true/false (false default)\033[0m \n";
        $unique = trim(readline());
        if ($unique == "" || $unique == " " || $unique == 'false')
        {
            $unique = 'false';
        }elseif ($unique != "true") {
            $unique = 'true';
        }
        array_push($this->unique, $unique);
        self::CONTINUE();
    }

    public function CONTINUE()
    {
        echo "\033[31m\t \t Continuer ? yes/no (no default)\033[0m \n";
        $continue = trim(readline());

        if ($continue == "" || $continue == " ")
        {
            self::CREATE_entity();
        }else{
            $this->count_turn++;
            self::GET_COL_NAME();
        }
    }

    protected function CREATE_ENTITY()
    {
        var_dump($this->table_name, $this->col_name, $this->type_name, $this->nullable, $this->value);

        $file = fopen("./src/Entity/$this->table_name".".php", 'w+');
        fwrite($file, "<?php \n namespace Entity; \n class $this->table_name{ \n\n\t public function GET_SQL(){\n\t \$sql='CREATE TABLE IF NOT EXIST $this->table_name ( ");
            fwrite($file, "\n\t\t id INT AUTO_INCREMENT PRIMARY KEY");
            foreach ($this->col_name as $key => $value) {
                $unique = $this->unique[$key];
                if ($unique == 'true')
                {
                    $unique = 'UNIQUE';
                }else
                {
                    $unique = "";
                }
                if ($this->nullable[$key] == 'true')
                {
                    $nullable = 'null';
                }else{
                    $nullable = '';
                }
                if ($this->type_name[$key] == 'string')
                {
                    $int = $this->value[0];
                    fwrite($file, "\n\t\t$value VARCHAR($int) $unique $nullable,");
                    array_shift($this->value);
                }else{
                    fwrite($file,"\n\t\t$value ".strtoupper($this->type_name[$key])." $unique $nullable , " );
                }
            }
            fwrite($file, "\n\t\t created_at INT AUTO_INCREMENT PRIMARY KEY)';\n\t}");
    }

}

$Entity = new MakeEntity();