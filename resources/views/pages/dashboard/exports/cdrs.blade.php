

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>calldate</th>
            <th>clid</th>
            <th>src</th>
            <th>dst</th>
            <th>dcontext</th>
            <th>channel</th>
            <th>dstchannel</th>
            <th>lastapp</th>
            <th>lastdata</th>
            <th>duration</th>
            <th>billsec</th>
            <th>disposition</th>
            <th>amaflags</th>
            <th>accountcode</th>
            <th>uniqueid</th>
            <th>userfield</th>
            <th>did</th>
            <th>recordingfile</th>
            <th>cnum</th>
            <th>cnam</th>
            <th>outbound_cnum</th>
            <th>outbound_cnam</th>
            <th>dst_cnam</th>
            <th>dst_cnam</th>
            <th>linkedid</th>
            <th>peeraccount</th>
            <th>sequence</th>
            <th>created_at</th>
            <th>updated_at</th>
            <!-- Add more headings as needed -->
        </tr>
    </thead>
<!--
`id`, `calldate`, `clid`, `src`, `dst`, `dcontext`, `channel`, `dstchannel`, `lastapp`, `lastdata`, `duration`, `billsec`, `disposition`, `amaflags`, `accountcode`, `uniqueid`, `userfield`, `did`, `recordingfile`, `cnum`, `cnam`, `outbound_cnum`, `outbound_cnam`, `dst_cnam`, `linkedid`, `peeraccount`, `sequence`, `created_at`, `updated_at`
-->
    <tbody>
        @foreach($cdrs as $cdr)
            <tr>
                <td>{{ $cdr->id }}</td>
                <td>{{ date("F, m Y", strtotime($cdr->calldate)) }}</td>
                <td>{{ $cdr->clid }}</td>
                <td>{{ $cdr->src }}</td>
                <td>{{ $cdr->dst }}</td>
                <td>{{ $cdr->dcontext }}</td>
                <td>{{ $cdr->channel }}</td>
                <td>{{ $cdr->dstchannel }}</td>
                <td>{{ $cdr->lastapp }}</td>
                <td>{{ $cdr->lastdata }}</td>
                <td>{{ $cdr->duration }}</td>
                <td>{{ $cdr->billsec }}</td>
                <td>{{ $cdr->disposition }}</td>
                <td>{{ $cdr->amaflags }}</td>
                <td>{{ $cdr->accountcode }}</td>
                <td>{{ $cdr->uniqueid }}</td>
                <td>{{ $cdr->userfield }}</td>
                <td>{{ $cdr->did }}</td>
                <td>{{ $cdr->recordingfile }}</td>
                <td>{{ $cdr->cnum }}</td>
                <td>{{ $cdr->cnam }}</td>
                <td>{{ $cdr->outbound_cnum }}</td>
                <td>{{ $cdr->outbound_cnam }}</td>
                <td>{{ $cdr->dst_cnam }}</td>
                <td>{{ $cdr->linkedid }}</td>
                <td>{{ $cdr->peeraccount }}</td>
                <td>{{ $cdr->sequence }}</td>
                <td>{{ $cdr->created_at }}</td>
                <td>{{ $cdr->updated_at }}</td>
                <!-- Add more data cells as needed -->
            </tr>
        @endforeach
    </tbody>
</table>
