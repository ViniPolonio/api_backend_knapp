<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Departament;

class DepartamentSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            [
                'title' => 'Recursos Humanos',
                'description' => 'Gestão de pessoas, recrutamento, treinamento e benefícios.',
                'status' => 1,
            ],
            [
                'title' => 'Financeiro',
                'description' => 'Gerenciamento financeiro, pagamentos, orçamentos e controle de custos.',
                'status' => 1,
            ],
            [
                'title' => 'Tecnologia da Informação (TI)',
                'description' => 'Suporte técnico, desenvolvimento de sistemas, infraestrutura e segurança da informação.',
                'status' => 1,
            ],
            [
                'title' => 'Marketing',
                'description' => 'Promoção da marca, publicidade, pesquisa de mercado e comunicação.',
                'status' => 1,
            ],
            [
                'title' => 'Vendas',
                'description' => 'Atendimento ao cliente, negociação e fechamento de contratos comerciais.',
                'status' => 1,
            ],
            [
                'title' => 'Contas a Receber',
                'description' => 'Gestão das receitas e controle dos recebimentos financeiros.',
                'status' => 1,
            ],
            [
                'title' => 'Contas a Pagar',
                'description' => 'Controle dos pagamentos, fornecedores e obrigações financeiras.',
                'status' => 1,
            ],
            [
                'title' => 'Estoque',
                'description' => 'Gerenciamento de inventário, armazenamento e logística interna.',
                'status' => 1,
            ],
            [
                'title' => 'Jurídico',
                'description' => 'Assessoria legal, contratos, compliance e questões regulatórias.',
                'status' => 1,
            ],
            [
                'title' => 'Pesquisa e Desenvolvimento (P&D)',
                'description' => 'Inovação, desenvolvimento de produtos e melhorias tecnológicas.',
                'status' => 1,
            ],
            [
                'title' => 'Logística',
                'description' => 'Planejamento e execução do transporte e distribuição de mercadorias.',
                'status' => 1,
            ],
            [
                'title' => 'Atendimento ao Cliente',
                'description' => 'Suporte e resolução de dúvidas e problemas dos clientes.',
                'status' => 1,
            ],
            [
                'title' => 'Qualidade',
                'description' => 'Controle e garantia da qualidade dos produtos e serviços.',
                'status' => 1,
            ],
            [
                'title' => 'Compras',
                'description' => 'Aquisição de materiais, negociação com fornecedores e gestão de contratos.',
                'status' => 1,
            ],
            [
                'title' => 'Administração',
                'description' => 'Gerenciamento geral das operações administrativas da empresa.',
                'status' => 1,
            ],
            [
                'title' => 'Planejamento Estratégico',
                'description' => 'Definição de metas, análise de mercado e planejamento de negócios.',
                'status' => 1,
            ],
            [
                'title' => 'Segurança do Trabalho',
                'description' => 'Garantia da saúde e segurança dos colaboradores no ambiente de trabalho.',
                'status' => 1,
            ],
            [
                'title' => 'Sustentabilidade',
                'description' => 'Gestão de políticas ambientais e sociais sustentáveis.',
                'status' => 1,
            ],
            [
                'title' => 'Comunicação Interna',
                'description' => 'Coordenação da comunicação entre equipes e colaboradores.',
                'status' => 1,
            ],
            [
                'title' => 'Relações Institucionais',
                'description' => 'Gestão do relacionamento com entidades externas e órgãos reguladores.',
                'status' => 1,
            ],
            [
                'title' => 'Auditoria Interna',
                'description' => 'Análise e controle dos processos internos para garantir conformidade.',
                'status' => 1,
            ],
            [
                'title' => 'Desenvolvimento de Negócios',
                'description' => 'Identificação de oportunidades e expansão comercial.',
                'status' => 1,
            ],
        ];

        foreach ($departments as $dept) {
            Departament::create($dept);
        }
    }
}
