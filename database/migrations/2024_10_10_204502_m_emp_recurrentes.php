<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('m_emp_recurrentes',function(Blueprint $table){
            // DATOS PERSONALES
            $table->id('idTransEmp');
            $table->string('cCodCia',4)->comment('Código de compañia'); 
            $table->string('cCodEmp',6)->nullable()->comment('Este campo no es Actualizable.'); 
            $table->integer('nCssOrden')->length(4)->comment('Este campo no es Actualizable.'); 
            $table->string('cNombre',17)->nullable()->comment('Nombre de empleado'); 
            $table->string('cApellido',17)->nullable()->comment('Apellido de empleado');  
            $table->string('cCedula',17)->nullable()->comment('Cedula de empleado');  
            $table->string('cDV',2)->nullable()->comment('Digito verificador');
            $table->string('cSegSoc',17)->nullable()->comment('Numero de seguro social');
            $table->date('dNac')->nullable()->comment('Fecha de nacimiento dd-mm-yyyy');
            $table->string('cGrupoISR',1)->nullable()->comment('Impuesto sobre la renta');
            $table->integer('nDepend')->length(2)->default('0')->comment('Cantidad de dependientes');
            $table->boolean('lDeclara')->default('0')->comment('Establese si el empleado presenta o no una Declaración de Renta de forma independiente. T para Cierto , F para Falso'); 
            $table->string('cSexo',1)->nullable()->comment('M = MASCULINO, F  = FEMENINO'); 
            $table->string('cEstCivil',1)->nullable()->comment('S=SOLTERO, C=CASADO, D=DIVORCIADO, V=VIUDO, U=UNIDO'); 
            $table->string('cTipoSal',1)->nullable()->comment('Este campo no es Actualizable. Tipo de salario, tal como fué pastado en el contrato H=POR HORA, M=POR MES');
            $table->decimal('nHorasReg',6,2)->default('0.0')->commment('Horas regulares que el empleado trabaja en cada periodo de pago');
            $table->decimal('nSalPactad',10,2)->default('0.0')->comment('Salario pactado. Si el salario es por mes, colocar el salario mensual. Si el salario es por hora, colocar la rata por hora.');
            $table->decimal('nGastoRep',8,2)->default('0.0')->comment('Gasto de representación a pagar en cada periodo de pago');
            $table->decimal('nTransp',8,2)->default('0.0')->comment('Monto que se le debe pagar al empleado de forma recurrente en concepto de transporte.');
            $table->decimal('nViatico',8,2)->default('0.0')->comment('Monto que se le debe pagar al empleado de forma recurrente en concepto de viáticos.');
            
            $table->string('cCodTar',18)->nullable()->comment('código de tarjeta'); 
            $table->string('cStatus',1)->nullable()->comment('Estatus del empleado A=ACTIVO, S=SUSPENDIDO, L=EN LICENCIA, C=CESANTE, V=VACACIONES'); 
            $table->string('cTipoEmp',1)->nullable()->comment('Tipo de Empleado P = Permanente, E = Eventual'); 
            $table->string('cTipoTrab',1)->nullable()->comment('Tipo de Trabajador, N=Normal, C=Construccion, P=Portuario, A=Agropecuario'); 
            $table->string('cFormaPago',1)->nullable()->comment('Forma de pafogo E = EFECTIVO, C = CHEQUE, D = DEPOSITO DIRECTO / ACH'); 
            $table->string('cCodGru',6)->nullable()->comment('Grupo de pago o Como se le paga: S=SEMANAL, Q=QUINCENAL, B=BISEMANAL, M=MENSUAL'); 
            $table->string('cTipoCta',1)->nullable()->comment('Tipo de Cuenta del Empleado. A = Ahorro, C = Corriente'); 
            $table->string('cCuenta1',20)->nullable()->comment('Número de cuenta del empleado'); 
            $table->string('cRTBanco',9)->nullable()->comment('Ruta y Tránsito del banco en el cual el empleado mantiene su tarjeta clave, debe tener nueve (9) dígitos en total Ej. 000000072'); 
            $table->date('dIngreso')->nullable()->comment('Fecha de ingreso dd-mm-yyyy');
            $table->date('dLiq')->nullable()->comment('Fecha de la última liquidación echa al empleado dd-mm-yyyy');
            $table->string('dUltVac')->nullable()->comment('Vacaciones pagadas hata: Se refiere la fecha hasta donde se han cancelado el dinero de las vacaciones del empleado dd-mm-yyyy');
            $table->string('dVacTomHas')->nullable()->comment('Vacaciones tomadas hasta: Se refiere la fecha hasta donde se le han cancelado el tiempo de las vacacionesel al empleado dd-mm-yyyy');
            $table->boolean('lSindicato',1)->nullable()->comment('Si el empleado pertenece al sindicato: T=Cierto F=Falso'); 
            $table->string('cCodDep',6)->nullable()->comment('Código de Departamento'); 
            $table->string('cCodCco',6)->nullable()->comment('Códgipo de CECO PAYDAY utilzia los CECOS para distribuir los gastos entre cuentas del mayoy general.'); 
            $table->string('cCodCar',6)->nullable()->comment('Código del Cargo o puesto que ocupa el empleado.'); 
            $table->string('cCodPro',25)->nullable()->comment('Código del Proyecto'); 
            $table->string('cCodSpr',25)->nullable()->comment('Código de Fase o Actividad'); 
            $table->string('cCodSuc',3)->nullable()->comment('Código de sucursal'); 
            $table->string('cCodDiv',6)->nullable()->comment('Código de división en caso de existir'); 
            $table->string('cDir1',30)->nullable()->comment('dirección 1'); 
            $table->string('cDir2',30)->nullable()->comment('dirección 2'); 
            $table->string('cTelefono',10)->nullable()->comment('telefono 2');
            $table->string('cTelefono2',20)->nullable()->comment('telefono 2');
            $table->string('ccodempi1',30)->nullable()->comment('codigo1 de empleado disponible para interface con otras aplicaciones');
            $table->string('ccodempi2',30)->nullable()->comment('codigo2 de empleado disponible para interface con otras aplicaciones');
            $table->string('ccustom1',30)->nullable()->comment('Código central o Código SAP');
            $table->string('ccustom2',30)->nullable()->comment('cUbicación');
            $table->string('cemail',70)->nullable()->comment('email del empleado');
            $table->boolean('lPasaporte',1)->nullable()->comment('coloca P si lo registrado es un pasaporte');
            $table->string('cTipoSan',2)->nullable()->comment('tipo de sangre');
            $table->dateTime('FechaReg')->useCurrentOnUpdate()->useCurrent();
            $table->dateTime('dFechaPayDay')->nullable()->comment('Debe Permitir valores nulos, en este campo se coloca la fecha y la hora en que fue procesado este registro en PayDay. Se utiliza como filtro para mostrar los registros que todavía no han sido procesados, solo para importaciones en BD');
            $table->dateTime('nBanach')->length(2)->nullable()->comment('Número de Banco para ACH');
            $table->string('cCodHor',6)->nullable()->comment('Código de Horario');
             
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   Schema::dropIfExists('m_emp_recurrentes');}
};
