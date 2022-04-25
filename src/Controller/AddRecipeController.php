<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\Step;
use App\Entity\Type;
use App\Repository\RecipeRepository;
use App\Repository\StepRepository;
use App\Repository\TypeRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/administrateur')]
class AddRecipeController extends AbstractController
{
    #[Route('/ajouterUneRecette', name: 'app_add_recipe')]
    public function app_add_recipe(Request $request, TypeRepository $typeRepository, ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();

        $recipe = new Recipe();

        $types = $typeRepository->findBy([], ['name' => 'DESC']);

        if (!empty($request->request->all()))
        {
            $stepForm['stepFirst'] = $request->request->get('stepFirst');
            $stepForm['stepSecond'] = $request->request->get('stepSecond');
            $stepForm['stepThree'] = $request->request->get('stepThree');
            $stepForm['stepFour'] = $request->request->get('stepFour');

            $recipes['title'] = $request->request->get('title');
            $img = $request->files->get('img');
            $imgName = md5(uniqid()) . '.' .$img->guessExtension();
            $img->move($this->getParameter('uploadDirectory'), $imgName);

            $recipe->setTitle($recipes['title'])
                   ->setImg($imgName)
                   ->setActive(true)
                    ->setType($typeRepository->findOneBy(['id' => $request->request->get('type')]));

            foreach ($stepForm as $step){
                $newStep = new Step();

                $newStep->setSteps($step);

                $recipe->addStep($newStep);
                $entityManager->persist($newStep);
            }
            $entityManager->persist($recipe);
            $entityManager->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('recipe/addRecipe.html.twig', [
            'types' => $types
        ]);
    }
}
