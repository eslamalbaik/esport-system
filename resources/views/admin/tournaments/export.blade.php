@php echo '<?xml version="1.0" encoding="UTF-8"?>'; @endphp
@php echo '<?mso-application progid="Excel.Sheet"?>'; @endphp
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
          xmlns:o="urn:schemas-microsoft-com:office:office"
          xmlns:x="urn:schemas-microsoft-com:office:excel"
          xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
          xmlns:html="http://www.w3.org/TR/REC-html40">
  <DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
    <Author>{{ config('app.name', 'Esports Admin') }}</Author>
    <Created>{{ now()->toIso8601String() }}</Created>
    <Company>{{ config('app.name', 'Esports Admin') }}</Company>
  </DocumentProperties>
  <ExcelWorkbook xmlns="urn:schemas-microsoft-com:office:excel">
    <WindowHeight>8130</WindowHeight>
    <WindowWidth>15135</WindowWidth>
    <WindowTopX>120</WindowTopX>
    <WindowTopY>45</WindowTopY>
    <ProtectStructure>False</ProtectStructure>
    <ProtectWindows>False</ProtectWindows>
  </ExcelWorkbook>

  <Worksheet ss:Name="Registrations">
    <Table ss:ExpandedColumnCount="9">
      <Row>
        <Cell><Data ss:Type="String">Tournament</Data></Cell>
        <Cell><Data ss:Type="String">Game Name</Data></Cell>
        <Cell><Data ss:Type="String">Team Name</Data></Cell>
        <Cell><Data ss:Type="String">Player Name</Data></Cell>
        <Cell><Data ss:Type="String">Role</Data></Cell>
        <Cell><Data ss:Type="String">In-Game ID</Data></Cell>
        <Cell><Data ss:Type="String">Email</Data></Cell>
        <Cell><Data ss:Type="String">Phone</Data></Cell>
        <Cell><Data ss:Type="String">Age</Data></Cell>
      </Row>
      @forelse($allRegistrations as $registration)
        <Row>
          <Cell><Data ss:Type="String">{{ $registration['tournament'] }}</Data></Cell>
          <Cell><Data ss:Type="String">{{ $registration['game_name'] ?? '' }}</Data></Cell>
          <Cell><Data ss:Type="String">{{ $registration['team_name'] ?? '' }}</Data></Cell>
          <Cell><Data ss:Type="String">{{ $registration['player_name'] }}</Data></Cell>
          <Cell><Data ss:Type="String">{{ $registration['role'] }}</Data></Cell>
          <Cell><Data ss:Type="String">{{ $registration['ingame_id'] ?? '' }}</Data></Cell>
          <Cell><Data ss:Type="String">{{ $registration['email'] ?? '' }}</Data></Cell>
          <Cell><Data ss:Type="String">{{ $registration['phone'] ?? '' }}</Data></Cell>
          <Cell>
            @if(!is_null($registration['age'] ?? null))
              <Data ss:Type="Number">{{ $registration['age'] }}</Data>
            @else
              <Data ss:Type="String"></Data>
            @endif
          </Cell>
        </Row>
      @empty
        <Row>
          <Cell ss:MergeAcross="8"><Data ss:Type="String">No registrations recorded.</Data></Cell>
        </Row>
      @endforelse
    </Table>
  </Worksheet>

  <Worksheet ss:Name="Singles">
    <Table ss:ExpandedColumnCount="7">
      <Row>
        <Cell><Data ss:Type="String">Tournament</Data></Cell>
        <Cell><Data ss:Type="String">Game Name</Data></Cell>
        <Cell><Data ss:Type="String">Player Name</Data></Cell>
        <Cell><Data ss:Type="String">In-Game ID</Data></Cell>
        <Cell><Data ss:Type="String">Email</Data></Cell>
        <Cell><Data ss:Type="String">Phone</Data></Cell>
        <Cell><Data ss:Type="String">Age</Data></Cell>
      </Row>
      @forelse($singleRegistrations as $registration)
        <Row>
          <Cell><Data ss:Type="String">{{ $tournament->titleFor(app()->getLocale()) ?: $tournament->slug }}</Data></Cell>
          <Cell><Data ss:Type="String">{{ optional($registration->game)->titleFor(app()->getLocale()) }}</Data></Cell>
          <Cell><Data ss:Type="String">{{ $registration->player_name }}</Data></Cell>
          <Cell><Data ss:Type="String">{{ $registration->ingame_id }}</Data></Cell>
          <Cell><Data ss:Type="String">{{ $registration->email }}</Data></Cell>
          <Cell><Data ss:Type="String">{{ $registration->phone }}</Data></Cell>
          <Cell>
            @if(!is_null($registration->age))
              <Data ss:Type="Number">{{ $registration->age }}</Data>
            @else
              <Data ss:Type="String"></Data>
            @endif
          </Cell>
        </Row>
      @empty
        <Row>
          <Cell ss:MergeAcross="6"><Data ss:Type="String">No single registrations recorded.</Data></Cell>
        </Row>
      @endforelse
    </Table>
  </Worksheet>

  <Worksheet ss:Name="Teams">
    <Table ss:ExpandedColumnCount="8">
      <Row>
        <Cell><Data ss:Type="String">Tournament</Data></Cell>
        <Cell><Data ss:Type="String">Game Name</Data></Cell>
        <Cell><Data ss:Type="String">Team Name</Data></Cell>
        <Cell><Data ss:Type="String">Captain Name</Data></Cell>
        <Cell><Data ss:Type="String">Captain Email</Data></Cell>
        <Cell><Data ss:Type="String">Captain Phone</Data></Cell>
        <Cell><Data ss:Type="String">Game ID</Data></Cell>
        <Cell><Data ss:Type="String">Members</Data></Cell>
      </Row>
      @forelse($teamRegistrations as $team)
        @php
          $gameName = optional($team->game)->titleFor(app()->getLocale());
          $membersList = $team->members->map(function ($member) {
              return trim($member->member_name . ($member->member_ingame_id ? ' (' . $member->member_ingame_id . ')' : ''));
          })->filter()->implode(', ');
        @endphp
        <Row>
          <Cell><Data ss:Type="String">{{ $tournament->titleFor(app()->getLocale()) ?: $tournament->slug }}</Data></Cell>
          <Cell><Data ss:Type="String">{{ $gameName }}</Data></Cell>
          <Cell><Data ss:Type="String">{{ $team->team_name }}</Data></Cell>
          <Cell><Data ss:Type="String">{{ $team->captain_name }}</Data></Cell>
          <Cell><Data ss:Type="String">{{ $team->captain_email }}</Data></Cell>
          <Cell><Data ss:Type="String">{{ $team->captain_phone }}</Data></Cell>
          <Cell><Data ss:Type="String">{{ $team->game_id }}</Data></Cell>
          <Cell><Data ss:Type="String">{{ $membersList }}</Data></Cell>
        </Row>
      @empty
        <Row>
          <Cell ss:MergeAcross="7"><Data ss:Type="String">No team registrations recorded.</Data></Cell>
        </Row>
      @endforelse
    </Table>
  </Worksheet>
</Workbook>
