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

enum AcknowledgmentRequestedCode: string
{
    /**
     * No Interchange Acknowledgment Requested.
     */
    case _0 = '0';

    /**
     * Interchange Acknowledgment Requested (TA1).
     */
    case _1 = '1';

    /**
     * Interchange Acknowledgment Requested only when Interchange is "Rejected Because Of Errors".
     */
    case _2 = '2';

    /**
     * Interchange Acknowledgment Requested only when Interchange is "Rejected Because Of Errors" or "Accepted but Errors are Noted".
     */
    case _3 = '3';
}
