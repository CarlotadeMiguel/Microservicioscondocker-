<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Aws\Sns\SnsClient;
use Aws\Exception\AwsException;

class FormController extends Controller
{
    public function submit(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // Guardar en base de datos
        DB::table('form_data')->insert($data);

        // Enviar a SNS
        try {
            $sns = new SnsClient([
                'version' => 'latest',
                'region'  => 'us-east-1'
                // Si no usas rol IAM, añade aquí 'credentials'
            ]);

            $sns->publish([
                'TopicArn' => 'arn:aws:sns:us-east-1:642854116542:sns', // Sustituye por el ARN real de tu SNS
                'Message'  => json_encode($data)
            ]);
        } catch (AwsException $e) {
            // Puedes loguear el error si lo necesitas
        }

        return response()->json(['message' => 'Formulario enviado correctamente']);
    }
}
