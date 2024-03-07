<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            ['name' => 'Admin', 'email' => 'adm@adm', 'password' => Hash::make('1'), 'telefone' => '10001', 'cpf' => '01', ],
            ['name' => 'Bilbo', 'email' => '1@1', 'password' => Hash::make('1'), 'telefone' => '00012301', 'cpf' => '12312301', ],
            ['name' => 'Thorin', 'email' => '2@2', 'password' => Hash::make('1'), 'telefone' => '00048901', 'cpf' => '45645602', ],
            ['name' => 'Gandalf', 'email' => '3@3', 'password' => Hash::make('1'), 'telefone' => '98765209', 'cpf' => '78978903', ],
            ['name' => 'Kili', 'email' => '4@4', 'password' => Hash::make('1'), 'telefone' => '01964289', 'cpf' => '7897890304', ],
            ['name' => 'Bombur', 'email' => '5@5', 'password' => Hash::make('1'), 'telefone' => '76501856', 'cpf' => '76187305', ],
        ]);

        DB::table('enderecos')->insert([
            ['user_id' => '1', 'estado' => 'Ooo', 'cidade' => 'Cidadela', 'bairro' => 'Sei lá man', 'logradouro' => 'Rua 1 Número 1', 'cep' => '2020202', ],
            ['user_id' => '2', 'estado' => 'Terra Média', 'cidade' => 'O Condado', 'bairro' => 'Hobbiton', 'logradouro' => 'Uma toca no chão', 'cep' => '1010101', ],
            ['user_id' => '3', 'estado' => 'Arkham', 'cidade' => 'Sem nome', 'bairro' => 'Sei lá man', 'logradouro' => 'Rua 42 Número 0', 'cep' => '1234567', ],
            ['user_id' => '4', 'estado' => 'PE', 'cidade' => 'Garanhuns', 'bairro' => 'Sei lá man', 'logradouro' => '???', 'cep' => '5529????', ],
            ['user_id' => '5', 'estado' => 'Terra Média', 'cidade' => 'Num sei', 'bairro' => 'Montanha da Perdição', 'logradouro' => 'Tbm num sei', 'cep' => '1', ],
        ]);

        DB::table('compras')->insert([
            ['user_id' => 2, 'concluida' => true, 'data_compra' => '01/01/2024', 'total' => 530.5],
            ['user_id' => 2, 'concluida' => true, 'data_compra' => '10/01/2024', 'total' => 350],
            ['user_id' => 2, 'concluida' => true, 'data_compra' => '05/02/2024', 'total' => 125],
            ['user_id' => 2, 'concluida' => true, 'data_compra' => '22/01/2024', 'total' => 250],
            
            ['user_id' => 3, 'concluida' => true, 'data_compra' => '01/01/2024', 'total' => 230],
            ['user_id' => 3, 'concluida' => true, 'data_compra' => '15/01/2024', 'total' => 300],
            ['user_id' => 3, 'concluida' => true, 'data_compra' => '21/01/2024', 'total' => 30],
            ['user_id' => 3, 'concluida' => true, 'data_compra' => '22/01/2024', 'total' => 150],
            
            ['user_id' => 4, 'concluida' => true, 'data_compra' => '15/01/2024', 'total' => 1100],
            ['user_id' => 4, 'concluida' => true, 'data_compra' => '13/02/2024', 'total' => 290],
            ['user_id' => 4, 'concluida' => true, 'data_compra' => '20/02/2024', 'total' => 1500],
            
            ['user_id' => 5, 'concluida' => true, 'data_compra' => '01/01/2024', 'total' => 3500],
            ['user_id' => 5, 'concluida' => true, 'data_compra' => '30/01/2024', 'total' => 3230],
            
            ['user_id' => 2, 'concluida' => false, 'data_compra' => null, 'total' => null],
            ['user_id' => 3, 'concluida' => false, 'data_compra' => null, 'total' => null],
            ['user_id' => 4, 'concluida' => false, 'data_compra' => null, 'total' => null],
            ['user_id' => 5, 'concluida' => false, 'data_compra' => null, 'total' => null],
            ['user_id' => 6, 'concluida' => false, 'data_compra' => null, 'total' => null],
            
        ]);

        DB::table('pagamentos')->insert([
            ['compra_id' => 1, 'nome_titular' => 'Bilbo', 'data_vencimento_cartao' => '01/12/2032', 'numero_cartao' => '0101010', 'cod_seguranca' => '001', 'endereco_entrega' => 'Terra Média | O Condado | Hobbiton | | Uma toca no chão | 1010101'],
            ['compra_id' => 2, 'nome_titular' => 'Bilbo', 'data_vencimento_cartao' => '01/12/2032', 'numero_cartao' => '0101010', 'cod_seguranca' => '001', 'endereco_entrega' => 'Terra Média | O Condado | Hobbiton | | Uma toca no chão | 1010101'],
            ['compra_id' => 3, 'nome_titular' => 'Frodo', 'data_vencimento_cartao' => '01/10/2025', 'numero_cartao' => '0811243', 'cod_seguranca' => '130', 'endereco_entrega' => 'Terra Média | O Condado | Hobbiton | | Uma toca no chão | 1010101'],
            ['compra_id' => 4, 'nome_titular' => 'Frodo', 'data_vencimento_cartao' => '01/10/2025', 'numero_cartao' => '0811243', 'cod_seguranca' => '130', 'endereco_entrega' => 'Terra Média | O Condado | Hobbiton | | Uma toca no chão | 1010101'],
            
            ['compra_id' => 5, 'nome_titular' => 'Thorin', 'data_vencimento_cartao' => '10/11/2030', 'numero_cartao' => '0197124', 'cod_seguranca' => '042', 'endereco_entrega' => 'Arkham | Sem nome | Sei lá man | Rua 42 Número 0 | 1234567'],
            ['compra_id' => 6, 'nome_titular' => 'Thorin', 'data_vencimento_cartao' => '10/11/2030', 'numero_cartao' => '0197124', 'cod_seguranca' => '042', 'endereco_entrega' => 'Arkham | Sem nome | Sei lá man | Rua 42 Número 0 | 1234567'],
            ['compra_id' => 7, 'nome_titular' => 'Thorin', 'data_vencimento_cartao' => '10/11/2030', 'numero_cartao' => '0197124', 'cod_seguranca' => '042', 'endereco_entrega' => 'Arkham | Sem nome | Sei lá man | Rua 42 Número 0 | 1234567'],
            ['compra_id' => 8, 'nome_titular' => 'Thorin', 'data_vencimento_cartao' => '10/11/2030', 'numero_cartao' => '0197124', 'cod_seguranca' => '042', 'endereco_entrega' => 'Arkham | Sem nome | Sei lá man | Rua 42 Número 0 | 1234567'],
            
            ['compra_id' => 9, 'nome_titular' => 'Gandalf', 'data_vencimento_cartao' => '01/12/2032', 'numero_cartao' => '0305171', 'cod_seguranca' => '100', 'endereco_entrega' => 'PE | Garanhuns | Sei lá man | ??? | 55292210'],
            ['compra_id' => 10, 'nome_titular' => 'Gandalf', 'data_vencimento_cartao' => '01/12/2032', 'numero_cartao' => '0305171', 'cod_seguranca' => '100', 'endereco_entrega' => 'PE | Garanhuns | Sei lá man | ??? | 55292210'],
            ['compra_id' => 11, 'nome_titular' => 'Gandalf', 'data_vencimento_cartao' => '01/12/2032', 'numero_cartao' => '0305171', 'cod_seguranca' => '100', 'endereco_entrega' => 'PE | Garanhuns | Sei lá man | ??? | 55292210'],
            
            ['compra_id' => 12, 'nome_titular' => 'Kili', 'data_vencimento_cartao' => '01/01/2028', 'numero_cartao' => '1234567', 'cod_seguranca' => '121', 'endereco_entrega' => 'Terra Média | Num sei | bairro | Montanha da Perdição | Tbm num sei | 1'],
            ['compra_id' => 13, 'nome_titular' => 'Fili', 'data_vencimento_cartao' => '06/09/2030', 'numero_cartao' => '7654321', 'cod_seguranca' => '211', 'endereco_entrega' => 'Terra Média | Num sei | bairro | Montanha da Perdição | Tbm num sei | 1'],
            
        ]);

        DB::table('categorias')->insert([
            [
                'nome' => 'Roupas',
                'descricao' => 'Roupas variadas',
            ],
            [
                'nome' => 'Equipamentos',
                'descricao' => 'Equipamentos esportivos',
            ],
            [
                'nome' => 'Acessórios para Corrida',
                'descricao' => 'Acessórios variados para corrida, incluindo cintos de hidratação, braçadeiras para smartphones e bonés.',
            ],
            [
                'nome' => 'Yoga e Pilates',
                'descricao' => 'Equipamentos e acessórios para a prática de Yoga e Pilates, incluindo mats, blocos e cintos.',
            ],
            [
                'nome' => 'Nutrição Esportiva',
                'descricao' => 'Produtos de nutrição esportiva, como suplementos, barras de proteínas e bebidas energéticas.',
            ],
            [
                'nome' => 'Treino em Casa',
                'descricao' => 'Equipamentos e acessórios para treino em casa, incluindo pesos livres, cordas de pular e faixas de resistência.',
            ],
            [
                'nome' => 'Esqui e Snowboard',
                'descricao' => 'Equipamentos e vestuário para esqui e snowboard, incluindo pranchas, botas e roupas térmicas.',
            ],
            [
                'nome' => 'Camping e Hiking',
                'descricao' => 'Equipamentos para camping e hiking, incluindo barracas, sacos de dormir e lanternas.',
            ],
            [
                'nome' => 'Natação',
                'descricao' => 'Artigos para natação, incluindo óculos, toucas e trajes de banho.',
            ],
            [
                'nome' => 'Esportes de Raquete',
                'descricao' => 'Equipamentos para esportes de raquete, como tênis, badminton e ping-pong, incluindo raquetes e bolas.',
            ],
            [
                'nome' => 'Eletrônicos Esportivos',
                'descricao' => 'Dispositivos eletrônicos para esportes, incluindo relógios inteligentes, monitores de atividade e câmeras de ação.',
            ],
            [
                'nome' => 'Surf e Esportes Aquáticos',
                'descricao' => 'Produtos para surf e outros esportes aquáticos, incluindo pranchas, wetsuits e acessórios.',
            ]
        ]);

        DB::table('produtos')->insert([
            ['categoria_id' => '1', 'nome' => 'Camisa de time', 'descricao' => 'Camisa de time aleatório', 'marca' => 'Adidas', 'cor' => '#000000', 'preco' => 110.50, 'peso' => 1, 'estoque' => 10,],
            ['categoria_id' => '2', 'nome' => 'Bola de futebol', 'descricao' => 'bola', 'marca' => 'Adidas', 'cor' => '#000000', 'preco' => 50, 'peso' => 2, 'estoque' => 5,],
            ['categoria_id' => '1', 'nome' => 'Legging Esportiva', 'descricao' => 'Legging esportiva para treino', 'marca' => 'FitPro', 'cor' => '#FF00FF', 'preco' => 120, 'peso' => 0.2, 'estoque' => 50],
            ['categoria_id' => '1', 'nome' => 'Jaqueta Corta-Vento', 'descricao' => 'Jaqueta leve para corrida', 'marca' => 'WindBreak', 'cor' => '#0000FF', 'preco' => 200, 'peso' => 0.5, 'estoque' => 30],
            ['categoria_id' => '2', 'nome' => 'Esteira Elétrica', 'descricao' => 'Esteira elétrica com 10 programas', 'marca' => 'RunFast', 'cor' => '#808080', 'preco' => 2500, 'peso' => 45, 'estoque' => 15],
            ['categoria_id' => '2', 'nome' => 'Kettlebell 16kg', 'descricao' => 'Kettlebell de ferro', 'marca' => 'IronGrip', 'cor' => '#8B0000', 'preco' => 160, 'peso' => 16, 'estoque' => 40],
            ['categoria_id' => '3', 'nome' => 'Cinto de Hidratação', 'descricao' => 'Cinto com dois compartimentos de água', 'marca' => 'HydroRun', 'cor' => '#00008B', 'preco' => 90, 'peso' => 0.3, 'estoque' => 50],
            ['categoria_id' => '3', 'nome' => 'Braçadeira para Smartphone', 'descricao' => 'Braçadeira ajustável para corrida', 'marca' => 'SmartFit', 'cor' => '#008000', 'preco' => 60, 'peso' => 0.1, 'estoque' => 70],
            ['categoria_id' => '4', 'nome' => 'Mat de Yoga Ecológico', 'descricao' => 'Mat de yoga feito de material sustentável', 'marca' => 'EcoYoga', 'cor' => '#8FBC8F', 'preco' => 180, 'peso' => 1, 'estoque' => 40],
            ['categoria_id' => '4', 'nome' => 'Bloco de Yoga', 'descricao' => 'Bloco para prática de yoga e pilates', 'marca' => 'BalanceBlock', 'cor' => '#FFD700', 'preco' => 50, 'peso' => 0.5, 'estoque' => 60],
            ['categoria_id' => '5', 'nome' => 'Whey Protein Isolado', 'descricao' => 'Suplemento de proteína isolada', 'marca' => 'MuscleGain', 'cor' => '#FFFFFF', 'preco' => 250, 'peso' => 1, 'estoque' => 100],
            ['categoria_id' => '5', 'nome' => 'Barra de Proteína', 'descricao' => 'Barra de proteína com chocolate', 'marca' => 'EnergyBar', 'cor' => '#8B4513', 'preco' => 10, 'peso' => 0.05, 'estoque' => 200],
            ['categoria_id' => '6', 'nome' => 'Corda de Pular Ajustável', 'descricao' => 'Corda de pular com contador', 'marca' => 'JumpMaster', 'cor' => '#FF4500', 'preco' => 80, 'peso' => 0.2, 'estoque' => 90],
            ['categoria_id' => '6', 'nome' => 'Faixas de Resistência', 'descricao' => 'Conjunto de faixas de resistência', 'marca' => 'FlexBand', 'cor' => '#FF69B4', 'preco' => 150, 'peso' => 0.5, 'estoque' => 80],
            ['categoria_id' => '7', 'nome' => 'Óculos de Snowboard', 'descricao' => 'Óculos com proteção UV para snowboard', 'marca' => 'SnowView', 'cor' => '#A52A2A', 'preco' => 300, 'peso' => 0.2, 'estoque' => 50],
            ['categoria_id' => '7', 'nome' => 'Prancha de Snowboard', 'descricao' => 'Prancha all-mountain para iniciantes', 'marca' => 'MountainWave', 'cor' => '#0000CD', 'preco' => 1200, 'peso' => 5, 'estoque' => 20],
            ['categoria_id' => '8', 'nome' => 'Barraca de Trilha para 2 Pessoas', 'descricao' => 'Barraca leve e resistente para trilha', 'marca' => 'TrailHome', 'cor' => '#008B8B', 'preco' => 600, 'peso' => 2.5, 'estoque' => 35],
            ['categoria_id' => '8', 'nome' => 'Lanterna Tática Recarregável', 'descricao' => 'Lanterna potente com foco ajustável', 'marca' => 'BrightNight', 'cor' => '#000000', 'preco' => 120, 'peso' => 0.25, 'estoque' => 100],
            ['categoria_id' => '9', 'nome' => 'Óculos de Natação Antiembaçante', 'descricao' => 'Óculos de natação com proteção UV', 'marca' => 'AquaVision', 'cor' => '#0000FF', 'preco' => 100, 'peso' => 0.1, 'estoque' => 80],
            ['categoria_id' => '9', 'nome' => 'Maiô de Competição', 'descricao' => 'Maiô feminino para competição', 'marca' => 'SpeedSwim', 'cor' => '#FF1493', 'preco' => 300, 'peso' => 0.2, 'estoque' => 40],
            ['categoria_id' => '10', 'nome' => 'Raquete de Tênis Profissional', 'descricao' => 'Raquete de tênis com corda de alta tensão', 'marca' => 'AceMaster', 'cor' => '#32CD32', 'preco' => 900, 'peso' => 0.3, 'estoque' => 30],
            ['categoria_id' => '10', 'nome' => 'Bolas de Ping-Pong', 'descricao' => 'Conjunto de bolas de ping-pong premium', 'marca' => 'PingPro', 'cor' => '#FFFFFF', 'preco' => 20, 'peso' => 0.05, 'estoque' => 100],
            ['categoria_id' => '11', 'nome' => 'Relógio Inteligente com GPS', 'descricao' => 'Relógio inteligente com monitoramento de atividades', 'marca' => 'SmartTrack', 'cor' => '#000000', 'preco' => 1200, 'peso' => 0.1, 'estoque' => 60],
            ['categoria_id' => '11', 'nome' => 'Câmera de Ação 4K', 'descricao' => 'Câmera de ação à prova dágua com estabilização', 'marca' => 'ActionCam', 'cor' => '#00008B', 'preco' => 900, 'peso' => 0.2, 'estoque' => 40],
            ['categoria_id' => '12', 'nome' => 'Prancha de Surf', 'descricao' => 'Prancha para surfistas intermediários', 'marca' => 'WaveRider', 'cor' => '#1E90FF', 'preco' => 1500, 'peso' => 3, 'estoque' => 25],
            ['categoria_id' => '12', 'nome' => 'Wetsuit para Surf', 'descricao' => 'Wetsuit de neoprene para águas frias', 'marca' => 'SeaGuard', 'cor' => '#000000', 'preco' => 800, 'peso' => 1, 'estoque' => 30],
            ['categoria_id' => '1', 'nome' => 'Camiseta Dry-Fit Masculina', 'descricao' => 'Camiseta respirável para exercícios', 'marca' => 'QuickDry', 'cor' => '#00FF00', 'preco' => 90, 'peso' => 0.15, 'estoque' => 70],
            ['categoria_id' => '1', 'nome' => 'Shorts Esportivo Feminino', 'descricao' => 'Shorts leve para atividades físicas', 'marca' => 'ActiveWear', 'cor' => '#FF69B4', 'preco' => 80, 'peso' => 0.2, 'estoque' => 50],
            ['categoria_id' => '2', 'nome' => 'Bicicleta Ergométrica', 'descricao' => 'Bicicleta ergométrica compacta', 'marca' => 'CycleFit', 'cor' => '#808080', 'preco' => 1500, 'peso' => 25, 'estoque' => 20],
            ['categoria_id' => '2', 'nome' => 'Kit Halteres Ajustáveis', 'descricao' => 'Kit de halteres com peso ajustável', 'marca' => 'FlexWeights', 'cor' => '#0000FF', 'preco' => 300, 'peso' => 10, 'estoque' => 40],
            ['categoria_id' => '3', 'nome' => 'Relógio de Corrida com GPS', 'descricao' => 'Relógio com GPS e monitor cardíaco', 'marca' => 'RunTech', 'cor' => '#FF4500', 'preco' => 1200, 'peso' => 0.1, 'estoque' => 30],
            ['categoria_id' => '3', 'nome' => 'Boné para Corredores', 'descricao' => 'Boné leve com proteção UV', 'marca' => 'SunCap', 'cor' => '#FFFFFF', 'preco' => 70, 'peso' => 0.1, 'estoque' => 100],
            ['categoria_id' => '4', 'nome' => 'Cinto de Yoga', 'descricao' => 'Cinto para auxílio em posições de yoga', 'marca' => 'YogaFlex', 'cor' => '#8B4513', 'preco' => 40, 'peso' => 0.1, 'estoque' => 60],
            ['categoria_id' => '4', 'nome' => 'Roda de Yoga', 'descricao' => 'Roda de yoga para aprimorar flexibilidade', 'marca' => 'FlexCircle', 'cor' => '#FFA07A', 'preco' => 150, 'peso' => 1.2, 'estoque' => 40],
            ['categoria_id' => '5', 'nome' => 'Shake de Proteína Vegana', 'descricao' => 'Shake de proteína 100% vegano', 'marca' => 'GreenPower', 'cor' => '#228B22', 'preco' => 120, 'peso' => 0.5, 'estoque' => 80],
            ['categoria_id' => '5', 'nome' => 'Gel Energético', 'descricao' => 'Gel energético para resistência esportiva', 'marca' => 'EnduroGel', 'cor' => '#FFD700', 'preco' => 15, 'peso' => 0.05, 'estoque' => 150],
            ['categoria_id' => '6', 'nome' => 'Anel de Pilates', 'descricao' => 'Anel de resistência para pilates', 'marca' => 'PilatesPro', 'cor' => '#FFB6C1', 'preco' => 100, 'peso' => 0.5, 'estoque' => 70],
            ['categoria_id' => '6', 'nome' => 'Tapete de Treino', 'descricao' => 'Tapete antiderrapante para exercícios', 'marca' => 'GripMat', 'cor' => '#00CED1', 'preco' => 120, 'peso' => 1, 'estoque' => 50],
            ['categoria_id' => '7', 'nome' => 'Capacete de Esqui', 'descricao' => 'Capacete com ventilação para esqui', 'marca' => 'SnowHead', 'cor' => '#A52A2A', 'preco' => 400, 'peso' => 0.6, 'estoque' => 30],
            ['categoria_id' => '7', 'nome' => 'Óculos de Esqui Antiembaçante', 'descricao' => 'Óculos antiembaçante para esqui e snowboard', 'marca' => 'ClearVision', 'cor' => '#00008B', 'preco' => 350, 'peso' => 0.2, 'estoque' => 40],
            ['categoria_id' => '8', 'nome' => 'Mochila de Hiking 40L', 'descricao' => 'Mochila resistente para hiking', 'marca' => 'TrailExplorer', 'cor' => '#778899', 'preco' => 400, 'peso' => 1.5, 'estoque' => 30],
            ['categoria_id' => '8', 'nome' => 'Bastões de Caminhada', 'descricao' => 'Par de bastões ajustáveis para caminhada', 'marca' => 'WalkPro', 'cor' => '#B8860B', 'preco' => 200, 'peso' => 0.8, 'estoque' => 50],
            ['categoria_id' => '9', 'nome' => 'Touca de Natação Silicone', 'descricao' => 'Touca de silicone durável para natação', 'marca' => 'AquaHead', 'cor' => '#FFA500', 'preco' => 50, 'peso' => 0.1, 'estoque' => 80],
            ['categoria_id' => '9', 'nome' => 'Pé de Pato de Treinamento', 'descricao' => 'Nadadeiras curtas para treino de natação', 'marca' => 'SpeedFin', 'cor' => '#20B2AA', 'preco' => 180, 'peso' => 1, 'estoque' => 40],
            ['categoria_id' => '10', 'nome' => 'Bola de Badminton', 'descricao' => 'Conjunto de petecas para badminton', 'marca' => 'FlyHigh', 'cor' => '#FFFFFF', 'preco' => 30, 'peso' => 0.05, 'estoque' => 100],
            ['categoria_id' => '10', 'nome' => 'Raquete de Squash', 'descricao' => 'Raquete leve para jogadores de squash', 'marca' => 'SquashMaster', 'cor' => '#8A2BE2', 'preco' => 500, 'peso' => 0.2, 'estoque' => 30],
            ['categoria_id' => '11', 'nome' => 'Monitor de Atividade', 'descricao' => 'Pulseira de atividade com monitoramento de sono', 'marca' => 'LifeTrack', 'cor' => '#000000', 'preco' => 300, 'peso' => 0.05, 'estoque' => 70],
            ['categoria_id' => '11', 'nome' => 'Fones de Ouvido Bluetooth Esportivos', 'descricao' => 'Fones de ouvido sem fio resistentes ao suor', 'marca' => 'BeatRun', 'cor' => '#FF4500', 'preco' => 250, 'peso' => 0.05, 'estoque' => 90],
            ['categoria_id' => '12', 'nome' => 'Leash para Prancha de Surf', 'descricao' => 'Cordinha resistente para prancha de surf', 'marca' => 'WaveCord', 'cor' => '#0000CD', 'preco' => 80, 'peso' => 0.2, 'estoque' => 60],
            ['categoria_id' => '12', 'nome' => 'Cera para Prancha', 'descricao' => 'Cera ecológica para maior aderência na prancha', 'marca' => 'EcoWax', 'cor' => '#F5DEB3', 'preco' => 20, 'peso' => 0.1, 'estoque' => 100],
            
        ]);

        DB::table(('item_compra'))->insert([
            // User_id 2
            ['compra_id' => 1, 'produto_id' => 1, 'quantidade' => 1, 'preco_total' => 110.5, 'preco_com_desconto' => 110.5],
            ['compra_id' => 1, 'produto_id' => 8, 'quantidade' => 1, 'preco_total' => 60, 'preco_com_desconto' => 60],
            ['compra_id' => 1, 'produto_id' => 11, 'quantidade' => 2, 'preco_total' => 500, 'preco_com_desconto' => 360],

            ['compra_id' => 2, 'produto_id' => 26, 'quantidade' => 5, 'preco_total' => 350, 'preco_com_desconto' => 350],

            ['compra_id' => 3, 'produto_id' => 2, 'quantidade' => 1, 'preco_total' => 50, 'preco_com_desconto' => 50],
            ['compra_id' => 3, 'produto_id' => 12, 'quantidade' => 10, 'preco_total' => 100, 'preco_com_desconto' => 75],

            ['compra_id' => 4, 'produto_id' => 48, 'quantidade' => 1, 'preco_total' => 250, 'preco_com_desconto' => 250],

            // User_id 3
            ['compra_id' => 5, 'produto_id' => 9, 'quantidade' => 1, 'preco_total' => 170, 'preco_com_desconto' => 170],
            ['compra_id' => 5, 'produto_id' => 10, 'quantidade' => 1, 'preco_total' => 60, 'preco_com_desconto' => 60],

            ['compra_id' => 6, 'produto_id' => 3, 'quantidade' => 3, 'preco_total' => 360, 'preco_com_desconto' => 300],

            ['compra_id' => 7, 'produto_id' => 33, 'quantidade' => 1, 'preco_total' => 40, 'preco_com_desconto' => 40],

            ['compra_id' => 8, 'produto_id' => 34, 'quantidade' => 1, 'preco_total' => 150, 'preco_com_desconto' => 150],

            // User_id 4
            ['compra_id' => 9, 'produto_id' => 31, 'quantidade' => 1, 'preco_total' => 1300, 'preco_com_desconto' => 1100],

            ['compra_id' => 10, 'produto_id' => 47, 'quantidade' => 1, 'preco_total' => 300, 'preco_com_desconto' => 290],

            ['compra_id' => 11, 'produto_id' => 29, 'quantidade' => 1, 'preco_total' => 1500, 'preco_com_desconto' => 1500],

            // User_id 5
            ['compra_id' => 12, 'produto_id' => 15, 'quantidade' => 1, 'preco_total' => 300, 'preco_com_desconto' => 300],
            ['compra_id' => 12, 'produto_id' => 16, 'quantidade' => 1, 'preco_total' => 1200, 'preco_com_desconto' => 1200],
            ['compra_id' => 12, 'produto_id' => 23, 'quantidade' => 1, 'preco_total' => 1200, 'preco_com_desconto' => 1200],
            ['compra_id' => 12, 'produto_id' => 39, 'quantidade' => 1, 'preco_total' => 390, 'preco_com_desconto' => 350],

            ['compra_id' => 13, 'produto_id' => 50, 'quantidade' => 5, 'preco_total' => 100, 'preco_com_desconto' => 75],
            ['compra_id' => 13, 'produto_id' => 49, 'quantidade' => 1, 'preco_total' => 80, 'preco_com_desconto' => 80],
            ['compra_id' => 13, 'produto_id' => 26, 'quantidade' => 1, 'preco_total' => 800, 'preco_com_desconto' => 600],
            ['compra_id' => 13, 'produto_id' => 24, 'quantidade' => 1, 'preco_total' => 900, 'preco_com_desconto' => 900],
            ['compra_id' => 13, 'produto_id' => 25, 'quantidade' => 1, 'preco_total' => 1500, 'preco_com_desconto' => 1500],
            ['compra_id' => 13, 'produto_id' => 12, 'quantidade' => 10, 'preco_total' => 100, 'preco_com_desconto' => 75],

        ]);

        DB::table('promocoes')->insert([
            [
                'nome' => 'Sexta Caotica',
                'descricao' => 'Chaos',
                'data_inicio' => '16/02/24',
                'data_fim' => '01/03/24',
                'percentagem' => 75,
            ],

            [
                'nome' => 'Corrida Contra o Tempo',
                'descricao' => 'Descontos acelerados em todos os produtos de corrida e fitness. Aproveite antes que o tempo acabe!',
                'data_inicio' => '22/02/2024',
                'data_fim' => '28/02/2024',
                'percentagem' => 50,
            ],
            [
                'nome' => 'Aventura Gelada',
                'descricao' => 'Equipe-se para o frio com ofertas quentes em equipamentos de esqui, snowboard e roupas de inverno.',
                'data_inicio' => '22/02/2024',
                'data_fim' => '31/12/2025',
                'percentagem' => 40,
            ],
            
        ]);

        DB::table('produto_promocao')->insert([
            ['produto_id' => 5, 'promocao_id' => 1],
            ['produto_id' => 20, 'promocao_id' => 1],
            ['produto_id' => 40, 'promocao_id' => 1],
            ['produto_id' => 11, 'promocao_id' => 1],
            ['produto_id' => 31, 'promocao_id' => 1],
            ['produto_id' => 1, 'promocao_id' => 1],

            // ['produto_id' => , 'promocao_id' => 2],
            // ['produto_id' => , 'promocao_id' => 2],
            // ['produto_id' => , 'promocao_id' => 2],

            ['produto_id' => 15, 'promocao_id' => 3],
            ['produto_id' => 16, 'promocao_id' => 3],
            ['produto_id' => 23, 'promocao_id' => 3],
            ['produto_id' => 39, 'promocao_id' => 3],
        ]);

        // \App\Models\User::factory(10)->create();
    }
}
