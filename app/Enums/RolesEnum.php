<?php

namespace App\Enums;

enum RolesEnum: string
{
    case MC = 'mestre_conselheiro';
    case PB = 'porta_bandeira';
    case D1 = 'primeiro_diacono';
    case CAP = 'capelao';
    case MCER = 'mestre_cerimonias';
    case OR = 'orador';
    case ESC = 'escrivao';
    case TR = 'tesoureiro';
    case HP = 'hospitaleiro';
    case P7 = 'patriotismo';
    case P1 = 'amor_filial';
    case P5 = 'fidelidade';
    case C2 = 'segundo_conselheiro';
    case P6 = 'pureza';
    case P2 = 'coisas_sagradas';
    case P4 = 'companheirismo';
    case M2 = 'segundo_mordomo';
    case P3 = 'cortesia';
    case M1 = 'primeiro_mordomo';
    case C1 = 'primeiro_conselheiro';
    case OG = 'organista';
    case D2 = 'segundo_diacono';
    case ST = 'sentinela';
}
