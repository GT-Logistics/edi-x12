<?php

/*
 * Copyright (C) 2024 GT+ Logistics.
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301
 * USA
 */

namespace Gtlogistics\EdiX12\Qualifier;

enum AuthorizationInformationQualifier: string
{
    /**
     * No Authorization Information Present (No Meaningful Information in I02).
     */
    case _00 = '00';

    /**
     * UCS Communications ID.
     */
    case _01 = '01';

    /**
     * EDX Communications ID.
     */
    case _02 = '02';

    /**
     * Additional Data Identification.
     */
    case _03 = '03';

    /**
     * Rail Communications ID.
     */
    case _04 = '04';

    /**
     * Department of Defense (DoD) Communication Identifier.
     */
    case _05 = '05';

    /**
     * United States Federal Government Communication Identifier.
     */
    case _06 = '06';

    /**
     * Truck Communications ID.
     */
    case _07 = '07';

    /**
     * Ocean Communications ID.
     */
    case _08 = '08';
}
