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
        echo " \n \t \t \033[31m/!\ POUR CHAQUE TABLE l'ID et CREATED_AT SERAS AUTOMATIQUEMENT CRÉÉ /!\033[0m \n \n";
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

        if ($type_name != "" && $type_name != "int" &&  $type_name != "string" && $type_name != "boolean" && $type_name != "timestamp" &&  $type_name != "blob" &&  $type_name != "date"&&$type_name != "text") {
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
        echo "\033[31m\t \t Continuer ? yes/no (yes default)\033[0m \n";
        $continue = trim(readline());

        if ($continue == "" || $continue == " ")
        {
            $this->count_turn++;
            self::GET_COL_NAME();
        }else{
            self::CREATE_entity();
        }
    }

    protected function CREATE_ENTITY()
    {
            $file = fopen("./src/Entity/$this->table_name".".php", 'w+');
            fwrite($file, "<?php \n namespace Entity; \n use Model\Database;\n use PDO;\n require_once './src/model/Database.php';\n class $this->table_name extends Database{ \n\n\t public function GET_SQL(){\n\t \$sql='CREATE TABLE IF NOT EXISTS $this->table_name ( ");
                fwrite($file, "\n\t\t id INT AUTO_INCREMENT PRIMARY KEY,");
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
                        $nullable = 'NULL';
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
                fwrite($file, "\n\t\t created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)';");
                fwrite($file, "\n\t \$statement = \$this->conn->prepare(\$sql);");
                fwrite($file, "\n\$statement->execute();");
                fwrite($file, "\n\t}");
                fwrite($file, "\n\tpublic function GET_CONNECTION(){\n");
                fwrite($file, "\t return \$this->conn;\n");
                fwrite($file,"}\n");
                foreach ($this->col_name as $key=> $value) {
                    
                    fwrite($file, "\t\tpublic function GET_ALL_".strtoupper($value)."(){\n");
                    fwrite($file,"\t \$sql='SELECT $value from $this->table_name';\n");
                    fwrite($file,"\t\$statement = self::GET_CONNECTION()->prepare(\$sql);\n");
                    fwrite($file,"\t\$statement->execute();\n");
                    fwrite($file,"\t\$result = \$statement->fetchAll(PDO::FETCH_ASSOC);\n");
                    fwrite($file,"\treturn \$result;\n}\n");

                        fwrite($file, "\t\tpublic function GET_".strtoupper($value)."(\$id){\n");
                        fwrite($file,"\t \$sql=\"SELECT $value from $this->table_name where id like \$id\";\n");
                        fwrite($file,"\t\$statement = self::GET_CONNECTION()->prepare(\$sql);\n");
                        fwrite($file,"\t\$statement->execute();\n");
                        fwrite($file,"\t\$result = \$statement->fetch(PDO::FETCH_ASSOC);\n");
                        fwrite($file,"\treturn \$result;\n}\n");

                        fwrite($file, "\t\tpublic function SET_".strtoupper($value)."(\$id, \$valeur){\n");
                            if ($this->type_name[$key] == 'int')
                            {
                                fwrite($file,"\t \$sql=\"UPDATE $this->table_name SET $value = \$valeur  where id like \$id\";\n");
                            }else{
                                fwrite($file,"\t \$sql=\"UPDATE $this->table_name SET $value = '\$valeur'  where id like \$id\";\n");
                            }
                            fwrite($file,"\t\$statement = self::GET_CONNECTION()->prepare(\$sql);\n");
                            fwrite($file,"\t\$statement->execute();\n");
                            fwrite($file,"\t}\n");
                }

                fwrite($file, "\n\tpublic function GET_ROW(\$id_row){\n\t");
                fwrite($file, "\$sql = \"SELECT * FROM $this->table_name WHERE id = \$id_row\";");
                fwrite($file, "\n\t\$statement = self::GET_CONNECTION()->prepare(\$sql);\n\t");
                fwrite($file, "\$statement->execute();\n\t");
                fwrite($file, "\$result =\$statement->fetch(PDO::FETCH_ASSOC);\n\t");
                fwrite($file, "return \$result;\n\t");
                fwrite($file, "\n}\n");

                    fwrite($file, "\n\tpublic function GET_ALL(){\n\t");
                    fwrite($file, "\$sql = \"SELECT * FROM $this->table_name\";");
                    fwrite($file, "\n\t\$statement = self::GET_CONNECTION()->prepare(\$sql);\n\t");
                    fwrite($file, "\$statement->execute();\n\t");
                    fwrite($file, "\$result =\$statement->fetchAll(PDO::FETCH_ASSOC);\n\t");
                    fwrite($file, "return \$result;\n\t");
                    fwrite($file, "\n}\n");
                    $col = "";
                    $col_name = "";
                    $col_bind ="";
                    foreach ($this->col_name as $value) {
                        $col .= "$"."$value, ";
                        $col_name .= "$value, ";
                        $col_bind .= ":$value, ";
                    }
                    
                    $col = rtrim($col, ", ");
                    $col_name = rtrim($col_name, ", ");
                    $col_bind = rtrim($col_bind, ":");
                    $col_bind = rtrim($col_bind, ", ");
                    
                    fwrite($file, "public function SET_ROW($col)\n\t");
                    fwrite($file, "{\n\t\t");
                    fwrite($file, "\$sql = \"INSERT INTO $this->table_name ($col_name) VALUES ($col_bind)\";");
                    fwrite($file, "\n\t\$statement = self::GET_CONNECTION()->prepare(\$sql);\n\t");

                        foreach ($this->col_name as $value) {
                            fwrite($file,"\$statement->bindParam(':$value', $$value);\n\t" );
                        }

                    fwrite($file, "\$statement->execute();\n\t");
                    fwrite($file, "\n}\n");
                    
                fwrite($file, "\n}\n");
                fwrite($file, "\$run = new $this->table_name();\n");
                fwrite($file, "\$run->GET_SQL();\n");
                fclose($file);
                $file ="./src/Entity/$this->table_name".".php";
                @system("php $file");
                        self::MAKE_FORM();
        }

            public function MAKE_FORM()
        {
            $file = fopen("./src/Form/{$this->table_name}form.php", 'w+');
        fwrite($file, "<?php\nnamespace Form;\n");
        fwrite($file, "use Entity\\{$this->table_name};\n"); 

        fwrite($file, "class {$this->table_name}form{\n");

        fwrite($file, "\tpublic function start(\$action, \$method){\n");
        fwrite($file, "\t\techo \"<form action='\$action' method='\$method'>\";\n");
        fwrite($file, "\t}\n");

        foreach ($this->col_name as $key => $value) {
            fwrite($file, "\n\tpublic function $value(){\n");
            if ($this->type_name[$key] == 'string' || $this->type_name[$key] == 'text') {
                fwrite($file, "\t\techo \"<input type='text' name='$value' id='$value'>\";\n");
            } elseif ($this->type_name[$key] == 'int') {
                fwrite($file, "\t\techo \"<input type='number' name='$value' id='$value'>\";\n"); 
            } elseif ($this->type_name[$key] == 'date') {
                fwrite($file, "\t\techo \"<input type='date' name='$value' id='$value'>\";\n");
            }
            fwrite($file, "\t}\n");
        }

        fwrite($file, "\n\tpublic function end(){\n");
        fwrite($file, "\t\techo \"<button type='submit'>Envoyer</button>\";\n"); 
        fwrite($file, "\t\techo \"</form>\";\n");
        fwrite($file, "\t}\n");

        $col_name = "";
        fwrite($file, "\n\tpublic function collect(){\n");
        foreach ($this->col_name as $value) {
            $col_name .= "$$value, ";
            fwrite($file, "\t\t\$$value = \$_POST['$value'];\n");
        }
            $col_name = rtrim($col_name, ", ");
            fwrite($file,"\t\t$$this->table_name = new $this->table_name();\n");
            fwrite($file,"\t\t$$this->table_name->SET_ROW($col_name);\n");

        fwrite($file, "\t\t}\n");
        fwrite($file, "}\n");

        fclose($file);

        }


    }

$Entity = new MakeEntity();