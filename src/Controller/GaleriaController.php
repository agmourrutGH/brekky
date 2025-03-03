<?php
namespace App\Controller;

use App\Entity\Comentario;
use App\Entity\Galeria;
use App\Entity\Calificacion;
use App\Manager\GaleriaManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GaleriaController extends AbstractController
{
    private $galeriaManager;

    public function __construct(GaleriaManager $galeriaManager)
    {
        $this->galeriaManager = $galeriaManager;
    }

    #[Route('/galeria', name: 'app_galeria')]
    public function index(Request $request): Response
    {
        $user = $this->getUser();
        $galerias = $this->galeriaManager->getGalerias();

        // 🔹 Agregar la calificación del usuario a cada galería
        foreach ($galerias as $galeria) {
            $calificacion = $this->galeriaManager->getCalificacionUsuarioEntity($galeria, $user);
            $galeria->calificacionUsuario = $calificacion ? $calificacion->getPuntuacion() : null;

            // Cargar los comentarios de la galería
            // Ya no necesitas setComentarios, solo accede a la colección de comentarios con getComentarios()
            $comentarios = $galeria->getComentarios(); // Obtener la colección de comentarios
        }

        // 🔹 Procesar publicación de imágenes
        if ($request->isMethod('POST') && $request->request->has('publicar')) {
            $descripcion = $request->request->get('descripcion');
            $imagen = $request->files->get('imagen');

            if ($imagen) {
                $filename = uniqid() . '.' . $imagen->guessExtension();
                $imagen->move($this->getParameter('images_directory'), $filename);

                $galeria = new Galeria();
                $galeria->setDescripcion($descripcion);
                $galeria->setImagen($filename);
                $galeria->setUser($user);
                $galeria->setFechaPublicacion(new \DateTime());

                $this->galeriaManager->saveGaleria($galeria);

                return $this->redirectToRoute('app_galeria');
            } else {
                $this->addFlash('error', 'La imagen es obligatoria');
            }
        }

        // 🔹 Procesar calificación de imágenes
        if ($request->isMethod('POST') && $request->request->has('calificar')) {
            $galeriaId = (int) $request->request->get('galeria_id');
            $puntuacion = (int) $request->request->get('puntuacion');
            $galeria = $this->galeriaManager->getGaleriaById($galeriaId);

            if ($galeria && $puntuacion >= 1 && $puntuacion <= 5) {
                // Verificar si ya existe una calificación del usuario
                $calificacion = $this->galeriaManager->getCalificacionUsuarioEntity($galeria, $user);

                if ($calificacion) {
                    // Actualizar calificación existente
                    $calificacion->setPuntuacion($puntuacion);
                } else {
                    // Crear nueva calificación
                    $calificacion = new Calificacion();
                    $calificacion->setGaleria($galeria);
                    $calificacion->setUser($user);
                    $calificacion->setPuntuacion($puntuacion);
                }

                $this->galeriaManager->addCalificacion($calificacion);

                return $this->redirectToRoute('app_galeria');
            } else {
                $this->addFlash('error', 'Puntuación inválida.');
            }
        }

        // 🔹 Procesar publicación de comentarios
        if ($request->isMethod('POST') && $request->request->has('comentar')) {
            $galeriaId = (int) $request->request->get('galeria_id');
            $contenido = trim($request->request->get('contenido'));
            $galeria = $this->galeriaManager->getGaleriaById($galeriaId);

            if ($galeria && !empty($contenido)) {
                $comentario = new Comentario();
                $comentario->setGaleria($galeria);
                $comentario->setUser($user);
                $comentario->setContenido($contenido);
                $comentario->setFechaPublicacion(new \DateTime());

                $this->galeriaManager->addComentario($comentario);

                return $this->redirectToRoute('app_galeria');
            } else {
                $this->addFlash('error', 'No puedes enviar un comentario vacío.');
            }
        }

        return $this->render('galeria/galeria.html.twig', [
            'galerias' => $galerias,
        ]);
    }

    #[Route('galeria/delete/{idGaleria}', name: 'delete_galeria', methods: ['POST'])]
    public function eliminar(int $idGaleria): Response
    {
        // Obtener la galería a eliminar
        $galeria = $this->galeriaManager->getGaleriaById($idGaleria);

        // Verificar si la galería existe
        if (!$galeria) {
            throw $this->createNotFoundException('La publicación no existe.');
        }

        // Eliminar la galería
        $this->galeriaManager->eliminarGaleria($galeria);

        // Agregar mensaje de éxito
        $this->addFlash('success', 'La publicación fue eliminada correctamente.');

        return $this->redirectToRoute('app_galeria');
    }
}
