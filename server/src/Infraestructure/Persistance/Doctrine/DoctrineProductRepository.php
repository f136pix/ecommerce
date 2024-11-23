<?php
//
//namespace App\Infraestructure\Persistance\Doctrine;
//
//use App\Application\Interfaces\ProductRepository;
//use App\Domain\Product;
//use Doctrine\ORM\EntityManagerInterface;
//
//class DoctrineProductRepository implements ProductRepository
//{
//    public function __construct(
//        private EntityManagerInterface $entityManager
//    ) {
//    }
//
//    public function findById(int $id): ?Product
//    {
//        return $this->entityManager->getRepository(Product::class)->find($id);
//    }
//
//    public function save(Product $product): void
//    {
//        $this->entityManager->persist($product);
//        $this->entityManager->flush();
//    }
//
//    public function remove(Product $product): void
//    {
//        $this->entityManager->remove($product);
//        $this->entityManager->flush();
//    }
//}
