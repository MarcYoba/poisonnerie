<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

final class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(ChartBuilderInterface $chartBuilder): Response
    {
        // 1. Graphique d'évolution des ventes (Bar / Line)
        $salesChart = $chartBuilder->createChart(Chart::TYPE_BAR);
        $salesChart->setData([
            'labels' => ['Ven', 'Sam', 'Dim', 'Lun', 'Mar', 'Mer', 'Jeu'],
            'datasets' => [
                [
                    'label' => 'Chiffre d\'Affaires (FCFA)',
                    'backgroundColor' => 'rgba(13, 110, 253, 0.75)',
                    'data' => [320000, 580000, 620000, 290000, 310000, 410000, 450000],
                ],
            ],
        ]);

        // 2. Graphique par catégorie (Doughnut)
        $categoryChart = $chartBuilder->createChart(Chart::TYPE_DOUGHNUT);
        $categoryChart->setData([
            'labels' => ['Poissons Frais', 'Crustacés', 'Mollusques', 'Surgelés', 'Transformés'],
            'datasets' => [
                [
                    'backgroundColor' => ['#0d6efd', '#0dcaf0', '#ffc107', '#6c757d', '#198754'],
                    'data' => [45, 20, 10, 15, 10],
                ],
            ],
        ]);

        return $this->render('home/index.html.twig', [
            'salesChart' => $salesChart,
            'categoryChart' => $categoryChart,
        ]);
    }
}
