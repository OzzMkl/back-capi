<?php

namespace App\Http\Controllers;

use App\Models\contactos;
use App\Models\direcciones;
use App\Models\emails;
use App\Models\telefonos;
use Dotenv\Exception\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactosController extends Controller
{

    public function index($type,$search){
        $contactos = contactos::with('telefonos','emails','direcciones')
                        ->select('contactos.*',
                        DB::raw("CONCAT(contactos.nombre,' ',contactos.apellido_paterno,' ',contactos.apellido_materno) as nombreCompleto"));

        //Filtrado por direccion
        if($type == 1 && $search != 'null'){
            $contactos->having('nombreCompleto','like','%'.$search.'%');
        }
        //Filtrado por telefono
        if($type == 2 && $search != 'null'){
            $contactos->whereHas('telefonos', function($q) use($search){
                $q->where('telefono','like','%'.$search.'%');
            });
        }
        //Filtrado por email
        if($type == 4 && $search != 'null'){
            $contactos->whereHas('emails', function($q) use($search){
                $q->where('email','like','%'.$search.'%');
            });
        }
        //Filtrado por direccion
        if($type == 3 && $search != 'null'){
            $contactos->whereHas('direcciones', function($q) use($search){
                $q->where(DB::raw("CONCAT(estado,' ',ciudad,' ',colonia,' ',calle,' ',numero)"),'like','%'.$search.'%');
            });
        }

        $contactos = $contactos->paginate(10);

        $data = array(
            'code'=> 200,
            'status'=> 'success',
            'data'=> $contactos,
        );
        return response()->json($data);
    }

    public function show($idContacto){
        $contacto = contactos::with('telefonos','emails','direcciones')
                        ->find($idContacto);

        if(!$contacto){
            $data = array(
                'code' => 404,
                'status' => 'error',
                'data'=> []
            );
        } else{
            $data = array(
                'code' => 200,
                'status' => 'success',
                'data'=> $contacto
            );
        }

        return response()->json($data);
    }

    public function store(Request $request){
        try {
            DB::beginTransaction();
            $request->validate([
                'nombre'=> 'required|string',
                'apellido_paterno'=> 'required|string',
                'apellido_materno'=> 'required|string',
            ]);
    
            $contacto = contactos::create([
                'nombre' => $request->nombre,
                'apellido_paterno' => $request->apellido_paterno,
                'apellido_materno' => $request->apellido_materno,
                'fecha_nacimiento' => $request->fecha_nacimiento,
            ]);
    
            if($request->has('telefonos')){
                foreach($request->telefonos as $telefonoData){
                    $telefono = new telefonos([
                        'telefono' => $telefonoData['telefono'],
                    ]);
                    $contacto->telefonos()->save($telefono);
                }
            }
    
            if($request->has('emails')){
                foreach($request->emails as $emailData){
                    $email = new emails([
                        'email' => $emailData['email'],
                    ]);
                    $contacto->emails()->save($email);
                }
            }
    
            if($request->has('direcciones')){
                foreach($request->direcciones as $dirData){
                    $dir = new direcciones([
                        'estado' => $dirData['estado'],
                        'ciudad' => $dirData['ciudad'],
                        'colonia' => $dirData['colonia'],
                        'calle' => $dirData['calle'],
                        'numero' => $dirData['numero'],
                        'codigo_postal' => $dirData['codigo_postal'],
                    ]);
                    $contacto->direcciones()->save($dir);
                }
            }

            DB::commit();
    
            $data = array(
                'code'=> 200,
                'status'=> 'success',
                'message' => 'El contacto ha sido guardado'
            );
    
            return response()->json($data);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'code' => 400,
                'status' => 'error',
                'message' => 'Error de validación',
                'errors' => $e
            ], 400);
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => 'Error de base de datos',
                'error' => $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => 'Error interno del servidor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $idContacto){
        try {
            DB::beginTransaction();
            $request->validate([
                'nombre' => 'required|string|max:100',
                'apellido_paterno' => 'required|string|max:100',
                'apellido_materno' => 'required|string|max:100',
            ]);
    
            $contacto = contactos::findOrFail($idContacto);
    
            $contacto->update([
                'nombre' => $request->nombre,
                'apellido_paterno' => $request->apellido_paterno,
                'apellido_materno' => $request->apellido_materno,
                'fecha_nacimiento' => $request->fecha_nacimiento,
            ]);
    
            // Eliminar los registros existentes antes de guardar los nuevos
            $contacto->telefonos()->delete();
            $contacto->emails()->delete();
            $contacto->direcciones()->delete();
    
            // Guardar los nuevos registros
            if ($request->has('telefonos')) {
                foreach ($request->telefonos as $telefonoData) {
                    $telefono = new telefonos([
                        'telefono' => $telefonoData['telefono']
                    ]);
                    $contacto->telefonos()->save($telefono);
                }
            }
    
            if ($request->has('emails')) {
                foreach ($request->emails as $emailData) {
                    $email = new emails([
                        'email' => $emailData['email']
                    ]);
                    $contacto->emails()->save($email);
                }
            }
    
            if ($request->has('direcciones')) {
                foreach ($request->direcciones as $dirData) {
                    $dir = new direcciones([
                        'estado' => $dirData['estado'],
                        'ciudad' => $dirData['ciudad'],
                        'colonia' => $dirData['colonia'],
                        'calle' => $dirData['calle'],
                        'numero' => $dirData['numero'],
                        'codigo_postal' => $dirData['codigo_postal'],
                    ]);
                    $contacto->direcciones()->save($dir);
                }
            }

            DB::commit();
    
            $data = array(
                'code'=> 200,
                'status'=> 'success',
                'message'=> 'El contacto ha sido actualizado'
            );
    
            return response()->json($data);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'code' => 400,
                'status' => 'error',
                'message' => 'Error de validación',
                'errors' => $e
            ], 400);
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => 'Error de base de datos',
                'error' => $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => 'Error interno del servidor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($idContacto){
        try {
            DB::beginTransaction();
            $contacto = contactos::findOrFail($idContacto);
    
            $contacto->delete();
            DB::commit();

            $data = array(
                'code'=> 200,
                'status'=> 'success',
                'message'=> 'Contacto eliminado satisfactoriamente'
            );
    
            return response()->json($data);
        } catch (\Exception $e) {
            DB::rollBack();
            $data = array(
                'code'=> 500,
                'status'=> 'error',
                'message'=> 'Error al eliminar el contacto',
                'error' => $e
            );
    
            return response()->json($data, 500);
        }
    }
    
}
